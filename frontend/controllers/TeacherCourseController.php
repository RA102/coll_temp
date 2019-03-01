<?php

namespace frontend\controllers;

use common\models\Course;
use common\models\organization\Institution;
use common\services\CourseService;
use common\services\person\EmployeeService;
use common\services\TeacherCourseService;
use Yii;
use common\models\TeacherCourse;
use yii\base\Module;
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
    private $institution;

    public function __construct(
        string $id,
        Module $module,
        CourseService $courseService,
        TeacherCourseService $teacherCourseService,
        EmployeeService $employeeService,
        array $config = []
    ) {
        $this->courseService = $courseService;
        $this->teacherCourseService = $teacherCourseService;
        $this->employeeService = $employeeService;
        $this->institution = \Yii::$app->user->identity->institution;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [ // TODO make authorized only
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

        if ($teacherCourse->load(Yii::$app->request->post())) {
            $teacherCourse->course_id = $course->id;
            if ($teacherCourse->save()) {
                return $this->redirect(['view', 'id' => $teacherCourse->id, 'course_id' => $course_id]);
            }
        }

        return $this->render('create', [
            'model' => $teacherCourse,
            'course' => $course,
            'teachers' => $this->employeeService->getTeachers($this->institution),
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

        if ($teacherCourse->load(Yii::$app->request->post())) {
            if ($teacherCourse->save()) {
                return $this->redirect(['view', 'id' => $teacherCourse->id, 'course_id' => $course_id]);
            }
        }

        return $this->render('update', [
            'model' => $teacherCourse,
            'course' => $course,
            'teachers' => $this->employeeService->getTeachers($this->institution),
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
