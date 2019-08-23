<?php

namespace frontend\controllers;

use common\models\person\Employee;
use common\models\organization\Group;
use common\models\organization\Institution;
use common\models\TeacherCourse;
use common\services\organization\GroupService;
use common\services\person\EmployeeService;
use frontend\models\forms\LessonForm;
use frontend\models\forms\LessonCopyForm;
use frontend\search\GroupSearch;
use Yii;
use common\models\Lesson;
use frontend\search\LessonSearch;
use yii\db\ActiveQuery;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\base\Module;
use yii\data\ActiveDataProvider;

/**
 * LessonController implements the CRUD actions for Lesson model.
 */
class LessonController extends Controller
{
    private $employeeService;
    private $groupService;
    private $institution;

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
                        'actions' => [
                            'index', 'groups', 'schedule', 'teachers', 'teacher-card', 'copy',
                            'ajax-feed', 'ajax-create', 'ajax-delete',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'ajax-create' => ['POST'],
                    'ajax-delete' => ['POST'],
                ],
            ],
        ];
    }

    public function __construct(
        string $id,
        Module $module,
        EmployeeService $employeeService,
        GroupService $groupService,
        array $config = []
    ) {
        $this->employeeService = $employeeService;
        $this->groupService = $groupService;
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGroups()
    {
        $searchModel = new GroupSearch();
        $searchModel->institution_id = $this->institution->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('groups', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Lesson models.
     * @param $group_id
     * @return mixed
     */
    public function actionSchedule($group_id)
    {
        $group = $this->findGroup($this->institution, $group_id);

        $teacherCourses = TeacherCourse::find()->joinWith([
            /** @see TeacherCourse::getGroups() */
            'groups' => function (ActiveQuery $query) use ($group) {
                $query->andWhere(['group.id' => $group->id]);
            }
        ])->all();

        $searchModel = new LessonSearch();
        $searchModel->group_id = $group_id;

        /*$lessons = $dataProvider->getModels();
        $result = [];
        foreach ($lessons as $lesson) {
            $result[] = LessonForm::createFromLesson($lesson, $group_id);
        }

        var_dump($result[0]['weeks_numbers']);
        die();*/

        return $this->render('schedule', [
            'group' => $group,
            'teacherCourses' => $teacherCourses,
            'teachers' => $this->employeeService->getTeachers($this->institution),
            'searchModel' => $searchModel,
        ]);
    }

    public function actionTeachers()
    {
        $query = $this->employeeService->getTeachersQuery($this->institution);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('teachers',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTeacherCard($teacher_id)
    {
        $model = Employee::findOne($teacher_id);
        $searchModel = new LessonSearch();
        $searchModel->teacher_id = $teacher_id;
        $dataProvider = $searchModel->search();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$query = Lesson::find()->where(['teacher_id' => $teacher_id]);

        return $this->render('teacher-card', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /* duplicate lesson to another weeks of course duration */
    public function actionCopy($lesson_id)
    {
        $model = Lesson::findOne($lesson_id);
        $teacherCourse = TeacherCourse::findOne($model->teacher_course_id);

        $start = \DateTime::createFromFormat('Y-m-d H:i:s', $teacherCourse->start_ts);
        $end = \DateTime::createFromFormat('Y-m-d H:i:s', $teacherCourse->end_ts);
        $interval = $start->diff($end);
        $weeks = (int)(($interval->days) / 7);
        $weeks_numbers = [];

        for ($i=1; $i<=$weeks; $i++) {
            $weeks_numbers[$i] = $i;
        }

        $current_date = $model->date_ts;
        $current_day = date('l', strtotime($model->date_ts));
        $first_day = date('Y-m-d', strtotime("first " . $current_day . " " . date('Y-m', strtotime($teacherCourse->start_ts))));
        $very_last_day = date('Y-m-d', strtotime($teacherCourse->end_ts));
        $all_days = [];
        for ($i = $first_day; $i <= $very_last_day; $i = date('Y-m-d', strtotime('+1 week ' . $i))) {
            $all_days[$i] = $i;
        }

        if ($model->load(Yii::$app->request->post())) {
            /*if ($model->save()) {
                return $this->redirect(['schedule', 'group_id' => $model->group_id]);
            }*/
            $dates = $_REQUEST['Date'];
            foreach ($dates as $date) {
                if ($date !== date('Y-m-d', strtotime($model->date_ts)) && $date != 0) {
            //var_dump($dates);die();
                    $lesson = Lesson::findOne(['date_ts' => date('Y-m-d H:i:s', strtotime($date . ' ' . date('H:i:s', strtotime($model->date_ts))))]);
                    if (!isset($lesson)) {
                        $lesson = new Lesson();
                        $lesson->teacher_course_id = $model->teacher_course_id;
                        $lesson->teacher_id = $model->teacher_id;
                        $lesson->date_ts = date('Y-m-d H:i:s', strtotime($date . ' ' . date('H:i:s', strtotime($model->date_ts))));
                        $lesson->duration = $model->duration;
                        $lesson->group_id = $model->group_id;
                        $lesson->save();
                    }
                }
            }
            return $this->redirect(['schedule', 'group_id' => $model->group_id]);
        }

        return $this->render('copy', [
            'model' => $model,
            'teacherCourse' => $teacherCourse,
            'weeks' => $weeks_numbers,
            'current_day' => $current_day,
            'all_days' => $all_days
        ]);
    }

    /**
     * Finds the Lesson model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lesson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lesson::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function findGroup(Institution $institution, $id)
    {
        if (($model = $this->groupService->getGroup($institution, $id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionAjaxFeed($group_id=null, $start, $end)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $searchModel = new LessonSearch();
        $searchModel->load(Yii::$app->request->queryParams);
        $searchModel->from_date = $start;
        $searchModel->to_date = $end;
        $dataProvider = $searchModel->search();

        $result = [];
        /** @var Lesson[] $lessons */
        $lessons = $dataProvider->getModels();
        foreach ($lessons as $lesson) {
            $result[] = LessonForm::createFromLesson($lesson, $group_id);
        }

        return $result;
    }

    public function actionAjaxCreate()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $form = new LessonForm();
        $form->load(Yii::$app->request->post());

        if ($form->validate()) {
            if ($form->id) {
                $model = $this->findModel($form->id);
            } else {
                $model = new Lesson();
            }

            $form->apply($model);
            $model->save();

            return $model;
        }

        return $form;
    }

    public function actionAjaxCopy($lesson_id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $form = new LessonCopyForm();
        $form->load(Yii::$app->request->post());

        if ($form->validate()) {
            if ($form->id) {
                $model = $this->findModel($form->id);
                $teacherCourse = TeacherCourse::findOne($model->teacher_course_id);
            } else {
                $model = new Lesson();
            }

            $form->copy($model);
            $model->save();

            return $model;
        }

        return $form;
    }

    public function actionAjaxDelete()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        $model->delete();

        return true;
    }
}
