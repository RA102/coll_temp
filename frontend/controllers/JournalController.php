<?php

namespace frontend\controllers;

use common\models\organization\Journal;
use common\models\organization\ReplacementJournal;
use common\models\organization\Classroom;
use frontend\search\ClassroomSearch;
use common\models\person\Person;
use common\models\person\Student;
use common\models\Lesson;
use common\models\RequiredDisciplines;
use common\models\Schedule;
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
    private $institution;

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

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $this->institution = \Yii::$app->user->identity->institution;
        return true;
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
        //$required = $group->requiredDisciplines;
        //$optional = $group->optionalDisciplines;

        return $this->render('group', [
            'group' => $group,
            'teacherCourses' => $teacherCourses,
            //'required' => $required,
            //'optional' => $optional,
        ]);
    }

    public function actionView2($group_id, $teacher_course_id, $type)
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

    public function sortFunction($a, $b) {
        return strtotime($a) - strtotime($b);
    }
    
    public function actionView($group_id, $teacher_course_id, $type)
    {
        $group = Group::findOne($group_id);
        /*$dataProvider = new ArrayDataProvider([
            'allModels' => $group->students,
        ]);*/
        $journal = Journal::find()->where(['group_id' => $group_id])->andWhere(['teacher_course_id' => $teacher_course_id])->all();
        $teacherCourse = TeacherCourse::findOne($teacher_course_id);
        $schedule = Schedule::find()->where(['group_id' => $group_id])->andWhere(['teacher_course_id' => $teacher_course_id])->all();
        $new_schedule = [];

        foreach ($schedule as $value) {
            $new_schedule[$value['weekday']][] = $value;
        }

        $semester_date = Yii::$app->user->identity->institution->semester_date;
        $weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $end = strtotime($semester_date[1]['end']);

        $dates = [];
        foreach ($new_schedule as $key => $value) {
            for ($i = strtotime(date('d-m-Y', strtotime('first ' . $weekdays[$key - 1] . ' ' . $semester_date[1]['start']))); $i <= $end; $i = strtotime('+1 week', $i)) {
                array_push($dates, date('d-m-Y', $i));
            } 
        }

        usort($dates, array($this, "sortFunction"));
        
        if ($type == 1) {
            $page = 'theory2';
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
            'dates' => $dates,
            'journal' => $journal,
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
            return $this->redirect(['view', 'group_id' => $group_id, 'teacher_course_id' => $teacher_course_id, 'type' => 1]);
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

    public function actionReplace($group_id, $date, $teacher_course_id, $type)
    {
        $group = Group::findOne($group_id);
        $teacherCourse = TeacherCourse::findOne($teacher_course_id);
        $teacherCourses = $group->teacherCourses;

        $types = [
            '1' => 'Журнал теоретического обучения',
            '2' => 'Журнал курсовых проектов, лабораторно-практических и графических работ',
            '3' => 'Журнал контрольных работ',
        ];

        $journal = Journal::find()
                ->where(['group_id' => $group_id])
                ->andWhere(['date_ts' => date('Y-m-d 00:00:00', strtotime($date))])
                ->andWhere(['teacher_course_id' => $teacher_course_id])
                ->andWhere(['type' => $type])
                ->one();
        $date_ts = date('d-m-Y', strtotime($date));

        $model = new ReplacementJournal();
        if ($model->load(Yii::$app->request->post())) {
            $model->date_ts = date('Y-m-d 00:00:00', strtotime($date));
            $model->group_id = $group_id;
            $model->teacher_course_id = $teacher_course_id;
            if ($model->save()) {
                return $this->redirect(['view', 'group_id' => $group_id, 'teacher_course_id' => $teacher_course_id, 'type' => 1]);
            }
        }

        return $this->render('replace', [            
            'model' => $model,
            'journal' => $journal,
            'group' => $group,
            'date_ts' => $date_ts,
            'type' => $type,
            'teacherCourse' => $teacherCourse,
            'teacherCourses' => $teacherCourses,
            'teachers' => $this->employeeService->getTeachersActive($this->institution),
        ]);
    }

    public function actionReplacement($group_id, $teacher_course_id)
    {
        $journals = ReplacementJournal::find()->andWhere(['group_id' => $group_id, 'teacher_course_id' => $teacher_course_id])->all();

        return $this->render('replacement', [
            'journals' => $journals,
        ]);
    }

    /*public function actionCreate($group_id, $date, $discipline_type, $discipline_id, $type)
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
                ->andWhere(['discipline_id' => $discipline_id])
                ->andWhere(['type' => $type])
                ->one();

        if ($model == null) {
            $model = new Journal();
            $model->type = $type;
            $model->institution_id = Yii::$app->user->identity->institution->id;
            $model->group_id = $group_id;
            $model->discipline_type = $discipline_type;
            $model->discipline_id = $discipline_id;
            $model->date_ts = $date;
            $model->data = $model->getAttributes();
        } else {
            $model->type = $model->type;
            $model->institution_id = $model->institution_id;
            $model->group_id = $model->group_id;
            $model->discipline_type = $model->discipline_type;
            $model->discipline_id = $model->discipline_id;
            $model->date_ts = $model->date_ts;
            //$model->data = $model->data;
            //var_dump($model->data);die();
        }

        if ($discipline_type == 1) {
            $discipline = RequiredDisciplines::findOne($discipline_id);
        }

        $classrooms = Classroom::find()->where(['institution_id' => Yii::$app->user->identity->institution->id])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view2', 'group_id' => $group_id, 'discipline_id' => $discipline_id, 'type' => 1]);
        //throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

        }

        return $this->render('create', [
            'model' => $model,
            'group' => $group,
            'date' => $date,
            'type' => $type,
            'discipline' => $discipline,
            'types' => $types,
        ]);
    }*/

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
