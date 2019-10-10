<?php

namespace frontend\controllers;

use common\models\Facultative;
use common\models\RequiredDisciplines;
use common\models\OptionalDisciplines;
use common\models\Practice;
use common\models\Exams;
use common\models\Ktp;
use common\models\Schedule;
use common\models\TeacherCourse;
use common\models\Lesson;
use common\models\organization\Classroom;
use common\models\organization\Group;
use common\models\organization\Institution;
use common\models\organization\InstitutionDiscipline;
use common\models\person\Employee;
use common\models\person\Student;
use common\services\organization\InstitutionDisciplineService;
use common\services\person\EmployeeService;
use frontend\search\GroupSearch;
use frontend\search\EmployeeSearch;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ScheduleController extends Controller
{
    private $institution;
    private $institutionDisciplineService;
    private $employeeService;

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

    public function __construct(
        string $id,
        Module $module,
        InstitutionDisciplineService $institutionDisciplineService,
        EmployeeService $employeeService,
        array $config = []
    ) {
        $this->institutionDisciplineService = $institutionDisciplineService;
        $this->employeeService = $employeeService;
        parent::__construct($id, $module, $config);
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
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GroupSearch();
        $searchModel->institution_id = $this->institution->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGroup($group_id)
    {
    	$lessons = Schedule::find()->where(['group_id' => $group_id])->all();

        $start_time = explode(':', $this->institution->shift_time[1]['start_time']);
        $duration = $this->institution->shift_time[1]['lesson_duration'];

    	$model = Group::findOne($group_id);
    	$weekdays = Schedule::getWeekdays();
    	$number = 1;

        return $this->render('group', [
        	'lessons' => $lessons,
        	'model' => $model, 
        	'number' => $number,
        	'weekdays' => $weekdays,
            'start_time' => $start_time,
            'duration' => $duration,
        ]);
    }

    public function actionTeacherCard($teacher_id)
    {
        $lessons = Schedule::find()
            ->joinWith('teacherCourse')
            ->where([TeacherCourse::tableName().'.teacher_id' => $teacher_id])->all();

        $start_time = explode(':', $this->institution->shift_time[1]['start_time']);
        $duration = $this->institution->shift_time[1]['lesson_duration'];

        $model = Employee::findOne($teacher_id);
        $weekdays = Schedule::getWeekdays();
        $number = 1;

        return $this->render('teacher-card', [
            'lessons' => $lessons,
            'model' => $model,
            'number' => $number,
            'weekdays' => $weekdays,
            'start_time' => $start_time,
            'duration' => $duration,
        ]);
    }

    public function actionClassroomCard($classroom_id)
    {
        $lessons = Schedule::find()
            ->where(['classroom_id' => $classroom_id])
            ->all();

        $start_time = explode(':', $this->institution->shift_time[1]['start_time']);
        $duration = $this->institution->shift_time[1]['lesson_duration'];

        $model = Classroom::findOne($classroom_id);
        $weekdays = Schedule::getWeekdays();
        $number = 1;

        return $this->render('classroom-card', [
            'lessons' => $lessons,
            'model' => $model,
            'number' => $number,
            'weekdays' => $weekdays,
            'start_time' => $start_time,
            'duration' => $duration,
        ]);
    }

    public function actionAddLesson($group_id, $weekday, $number)
    {
    	$group = Group::findOne($group_id);

    	$model = Schedule::find()->where(['weekday' => $weekday])->andWhere(['lesson_number' => $number])->one();

    	if ($model == null) {
	    	$model = new Schedule();
	    	$model->group_id = $group_id;
	    	$model->weekday = $weekday;
	    	$model->lesson_number = $number;
   	    }

        /*$disciplines = RequiredDisciplines::find()
                ->joinWith('institutionDiscipline')
                ->where([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id])->all();*/
        $teacherCourses = TeacherCourse::find()
                ->joinWith('groups')
                ->where([Group::tableName().'.id' => $group_id])->all();

        $classrooms = Classroom::find()->where(['institution_id' => $this->institution->id])->all();

        if ($model->load(Yii::$app->request->post())) {
        	$teacherCourse = TeacherCourse::findOne($model->teacher_course_id);

        	if ($model->double == 1) {
        		$model2 = new Schedule();
        		$model2->group_id = $model->group_id;
        		$model2->weekday = $model->weekday;
        		$model2->teacher_course_id = $model->teacher_course_id;
        		$model2->lesson_number = $model->lesson_number + 1;
        		$model2->classroom_id = $model->classroom_id;

	            if ($model->save() && $model2->save()) {
		        	$this->createLesson($model->id);
	            	$this->createLesson($model2->id);
	                return $this->redirect(['group', 'group_id' => $group_id]);
	            }	        		

            }
            elseif ($model->save()) {
	        	$this->createLesson($model->id);
            	return $this->redirect(['group', 'group_id' => $group_id]);
            }
        }

   	    return $this->render('add-lesson', [
   	    	'model' => $model,
   	    	'group' => $group,
            'teachers' => $this->employeeService->getTeachers($this->institution),
            'teacherCourses' => $teacherCourses,
            'classrooms' => $classrooms,
   	    ]);
    }

    protected function createLesson($schedule_id)
    {
        $schedule = Schedule::findOne($schedule_id);
        $semester_date = $this->institution->semester_date;
        $end = strtotime($semester_date[1]['end']);
        $shift_time = $this->institution->shift_time;
        $weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        $lesson_time = strtotime($shift_time[1]['start_time']) + 60*60*($schedule->lesson_number - 1);
        $time = date('H:i:s', $lesson_time);

        for ($i = strtotime(date('d-m-Y', strtotime('first ' . $weekdays[$schedule->weekday - 1] . ' ' . $semester_date[1]['start']))); $i <= $end; $i = strtotime('+1 week', $i)) {
	        $lesson = new Lesson();
	        $lesson->teacher_course_id = $schedule->teacher_course_id;
	        $lesson->teacher_id = $schedule->teacherCourse->teacher_id;
	        $lesson->group_id = $schedule->group_id;
	        $lesson->classroom_id = $schedule->classroom_id;
	        $lesson->duration = $shift_time[1]['lesson_duration'];
	        $lesson->date_ts = date('Y-m-d', $i) . ' ' . $time;
	        $lesson->save();
	    }
    }

    public function actionDelete($id)
    {
    	$model = Schedule::findOne($id);
    	$group_id = $model->group_id;
    	$model->delete();

    	return $this->redirect(['group', 'group_id' => $group_id]);
    }

}
