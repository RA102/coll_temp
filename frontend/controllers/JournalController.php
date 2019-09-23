<?php

namespace frontend\controllers;

use common\models\organization\Journal;
use common\models\organization\Classroom;
use frontend\search\ClassroomSearch;
use common\models\person\Person;
use common\models\person\Student;
use common\models\Lesson;
use common\models\TeacherCourse;
use common\services\organization\GroupService;
use common\services\person\PersonService;
use common\services\person\EmployeeService;
use common\models\organization\Group;
use frontend\models\forms\GroupAllocationForm;
use frontend\search\StudentSearch;
use frontend\search\GroupSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\ActiveQuery;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class JournalController extends Controller
{
    public $groupService;
    private $personService;
    private $employeeService;

    public function __construct(
        string $id, 
        $module, 
        GroupService $groupService, 
        PersonService $personService, 
        EmployeeService $employeeService,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->groupService = $groupService;
        $this->personService = $personService;
        $this->employeeService = $employeeService;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GroupSearch();
        $searchModel->institution_id = Yii::$app->user->identity->institution->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Journal model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionGroup($group_id)
    {
        $group = Group::findOne($group_id);
        $teacherCourses = $group->teacherCourses;

        return $this->render('group', [
            'group' => $group,
            'teacherCourses' => $teacherCourses,
        ]);
    }

    public function actionView($group_id, $teacher_course_id, $type)
    {
        $group = Group::findOne($group_id);
        /*$dataProvider = new ArrayDataProvider([
            'allModels' => $group->students,
        ]);*/
        $teacherCourse = TeacherCourse::findOne($teacher_course_id);
        $lessons = Lesson::find()
                    ->where(['group_id' => $group_id])
                    ->andWhere(['teacher_course_id' => $teacher_course_id])
                    ->orderBy(['date_ts' => SORT_ASC])
                    ->all();

        if ($type == 1) {
            $page = 'theory';
        } 
        elseif ($type == 2) {
            $page = 'practical';
        }
        elseif ($type == 3) {
            $page = 'exam';
        }

        return $this->render($page, [
            'group' => $group,
            'teacherCourse' => $teacherCourse,
            'lessons' => $lessons,
            //'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Journal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($group_id, $date, $teacher_course_id, $type)
    {
        $group = Group::findOne($group_id);

        $types = [
            '1' => 'Журнал теоретического обучения',
            '2' => 'Журнал курсовых проектов, лабораторно-практических и графических работ',
            '3' => 'Журнал контрольных работ',
        ];

        $model = Journal::find()
                ->where(['group_id' => $group_id])
                ->andWhere(['date_ts' => $date])
                ->andWhere(['teacher_course_id' => $teacher_course_id])
                ->andWhere(['type' => $type])
                ->one();

        if ($model == null) {
            $model = new Journal();
            $model->type = $type;
            $model->institution_id = Yii::$app->user->identity->institution->id;
            $model->group_id = $group_id;
            $model->teacher_course_id = $teacher_course_id;
            $model->date_ts = $date;
            $model->data = $model->getAttributes();
        } else {
            $model->type = $model->type;
            $model->institution_id = $model->institution_id;
            $model->group_id = $model->group_id;
            $model->teacher_course_id = $model->teacher_course_id;
            $model->date_ts = $model->date_ts;
            //$model->data = $model->data;
            //var_dump($model->data);die();
        }

        $teacherCourse = TeacherCourse::findOne($teacher_course_id);

        $classrooms = Classroom::find()->where(['institution_id' => Yii::$app->user->identity->institution->id])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['single', 'group_id' => $group_id, 'teacher_course_id' => $teacher_course_id]);
        //throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

        }

        return $this->render('create', [
            'model' => $model,
            'group' => $group,
            'date' => $date,
            'type' => $type,
            'teacherCourse' => $teacherCourse,
            'types' => $types,
        ]);
    }

    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $specialities = Yii::$app->user->identity->institution->specialities;

        return $this->render('update', [
            'model' => $model,
            'specialities' => $specialities,
        ]);
    }

    /**
     * Deletes an existing Group model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete_ts = date('Y-m-d H:i:s');
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Journal::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
