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
    public function actionView($group_id)
    {
        //$journals = Journal::find()->where(['group_id' => $group_id])->all();
        $group = Group::findOne($group_id);
        $teacherCourses = $group->teacherCourses;

        return $this->render('view', [
            //'journals' => $journals,
            'group' => $group,
            'teacherCourses' => $teacherCourses,
        ]);
    }

    public function actionSingle($group_id, $teacher_course_id)
    {
        $group = Group::findOne($group_id);
        /*$dataProvider = new ArrayDataProvider([
            'allModels' => $group->students,
        ]);*/
        $teacherCourse = TeacherCourse::findOne($teacher_course_id);
        $lessons = Lesson::find()->where(['group_id' => $group_id])->andWhere(['teacher_course_id' => $teacher_course_id])->orderBy(['date_ts' => SORT_ASC])->all();

        return $this->render('single', [
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
    public function actionCreate($group_id)
    {
        $group = Group::findOne($group_id);

        $types = [
            '1' => 'журнал теоретического обучения',
            '2' => 'журнал курсовых проектов',
            '3' => 'журнал контрольных работ',
        ];

        $model = new Journal();
        $model->institution_id = Yii::$app->user->identity->institution->id;
        $model->group_id = $group_id;

        $teacherCourses = TeacherCourse::find()->joinWith([
            /** @see TeacherCourse::getGroups() */
            'groups' => function (ActiveQuery $query) use ($group) {
                $query->andWhere(['group.id' => $group->id]);
            }
        ])->all();

        $classrooms = Classroom::find()->where(['institution_id' => Yii::$app->user->identity->institution->id])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['index']);
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

        }

        return $this->render('create', [
            'model' => $model,
            'teacherCourses' => $teacherCourses,
            'teachers' => $this->employeeService->getTeachers(\Yii::$app->user->identity->institution),
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
