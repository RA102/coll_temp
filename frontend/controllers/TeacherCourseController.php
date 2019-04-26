<?php

namespace frontend\controllers;

use common\models\Course;
use common\models\organization\Institution;
use common\services\CourseService;
use common\services\organization\GroupService;
use common\services\person\EmployeeService;
use common\services\TeacherCourseService;
use frontend\models\forms\TeacherCourseForm;
use Yii;
use common\models\TeacherCourse;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeacherCourseController implements the CRUD actions for TeacherCourse model.
 */
class TeacherCourseController extends Controller
{
    private $courseService;
    private $teacherCourseService;
    private $employeeService;
    private $groupService;
    private $institution;

    public function __construct(
        string $id,
        Module $module,
        CourseService $courseService,
        TeacherCourseService $teacherCourseService,
        EmployeeService $employeeService,
        GroupService $groupService,
        array $config = []
    ) {
        $this->courseService = $courseService;
        $this->teacherCourseService = $teacherCourseService;
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
                            'view',
                            'create', 'update',
                            'delete',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Displays a single TeacherCourse model.
     * @param $course_id
     * @param integer $id
     * @return mixed
     */
    public function actionView($course_id, $id)
    {
        $course = $this->findCourse($this->institution, $course_id);
        $teacherCourse = $this->findTeacherCourse($course, $id);

        return $this->render('view', [
            'model' => $teacherCourse,
            'course' => $course,
        ]);
    }

    /**
     * Creates a new TeacherCourse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $course_id
     * @return mixed
     */
    public function actionCreate($course_id)
    {
        $course = $this->courseService->getCourse($this->institution, $course_id);
        $teacherCourse = new TeacherCourse();

        $form = new TeacherCourseForm();

        if ($form->load(Yii::$app->request->post())) {
            $teacherCourse->setAttributes($form->getAttributes());
            $teacherCourse->course_id = $course->id;

            if ($teacherCourse->save()) {
                foreach ($form->group_ids as $group_id) {
                    $group = $this->groupService->getGroup($this->institution, $group_id);
                    $this->teacherCourseService->addGroup($teacherCourse, $group);
                }

                return $this->redirect(['view', 'id' => $teacherCourse->id, 'course_id' => $course_id]);
            }
        }

        return $this->render('create', [
            'model' => $form,
            'course' => $course,
            'teachers' => $this->employeeService->getTeachers($this->institution),
            'groups' => $this->groupService->getGroups($this->institution),
        ]);
    }

    /**
     * Updates an existing TeacherCourse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param $course_id
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($course_id, $id)
    {
        $course = $this->findCourse($this->institution, $course_id);
        $teacherCourse = $this->findTeacherCourse($course, $id);

        $form = new TeacherCourseForm(); // dirtyAttribute trait needed
        $form->setAttributes($teacherCourse->getAttributes());
        $group_ids = ArrayHelper::getColumn($teacherCourse->getGroups()->all(), 'id');
        $form->group_ids = $group_ids;

        if ($form->load(Yii::$app->request->post())) {
            $teacherCourse->setAttributes($form->getAttributes());
            $teacherCourse->course_id = $course->id;

            if ($teacherCourse->save()) {
                foreach (array_diff($group_ids, $form->group_ids) as $group_id) {
                    $group = $this->groupService->getGroup($this->institution, $group_id);
                    $this->teacherCourseService->deleteGroup($teacherCourse, $group);
                }
                foreach (array_diff($form->group_ids, $group_ids) as $group_id) {
                    $group = $this->groupService->getGroup($this->institution, $group_id);
                    $this->teacherCourseService->addGroup($teacherCourse, $group);
                }

                return $this->redirect(['view', 'id' => $teacherCourse->id, 'course_id' => $course_id]);
            }
        }

        return $this->render('update', [
            'model' => $form,
            'teacherCourse' => $teacherCourse,
            'course' => $course,
            'teachers' => $this->employeeService->getTeachers($this->institution),
            'groups' => $this->groupService->getGroups($this->institution),
        ]);
    }

    /**
     * Deletes an existing TeacherCourse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param $course_id
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($course_id, $id)
    {
        $course = $this->findCourse($this->institution, $course_id);
        $teacherCourse = $this->findTeacherCourse($course, $id);

        $teacherCourse->delete();

        return $this->redirect(['course/view', 'id' => $course->id]);
    }

    protected function findCourse(Institution $institution, $id)
    {
        $course = $this->courseService->getCourse($institution, $id);
        if ($course !== null) {
            return $course;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function findTeacherCourse(Course $course, $id)
    {
        $teacherCourse = $this->teacherCourseService->getTeacherCourse($course, $id);
        if ($teacherCourse !== null) {
            return $teacherCourse;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
