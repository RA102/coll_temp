<?php

namespace api\modules\v1\controllers;

use common\behaviours\PdsBearerAuth;
use common\models\Course;
use common\models\organization\Institution;
use common\models\organization\InstitutionDiscipline;
use common\models\person\Student;
use common\models\StudentSessionGrade;
use common\models\TeacherCourse;
use common\services\CourseService;
use common\services\LessonService;
use common\services\organization\GroupService;
use common\services\person\StudentService;
use common\services\StudentGradeService;
use common\services\TeacherCourseService;
use Yii;
use yii\db\ActiveQuery;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\base\Module;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    protected $groupService;
    protected $studentService;
    protected $courseService;
    protected $teacherCourseService;
    protected $lessonService;
    protected $studentGradeService;
    /** @var Institution */
    protected $institution;

    public function __construct(
        string $id,
        Module $module,
        GroupService $groupService,
        StudentService $studentService,
        CourseService $courseService,
        TeacherCourseService $teacherCourseService,
        LessonService $lessonService,
        StudentGradeService $studentGradeService,
        array $config = []
    ) {
        $this->groupService = $groupService;
        $this->studentService = $studentService;
        $this->courseService = $courseService;
        $this->teacherCourseService = $teacherCourseService;
        $this->lessonService = $lessonService;
        $this->studentGradeService = $studentGradeService;

        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['cors'] = [
            'class' => Cors::class,
            'actions' => [
                self::actionGroups => ['Access-Control-Request-Method' => ['GET']],
                self::actionStudents => ['Access-Control-Request-Method' => ['GET']],
                self::actionCourses => ['Access-Control-Request-Method' => ['GET']],
                self::actionLessons => ['Access-Control-Request-Method' => ['GET']],
            ]
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                self::actionGroups => ['GET'],
                self::actionStudents => ['GET'],
                self::actionCourses => ['GET'],
                self::actionLessons => ['GET'],
            ],
        ];
        $behaviors['authenticator'] = [
            'class' => PdsBearerAuth::class,
        ];
        return $behaviors;
    }

    public function beforeAction($action)
    {
        $result = parent::beforeAction($action);

        $this->institution = \Yii::$app->user->identity->institution;

        return $result;
    }

    const actionGroups = 'groups';
    public function actionGroups()
    {
        // TODO pagination needed?
        return $this->groupService->getGroups($this->institution);
    }

    const actionStudents = 'students';
    public function actionStudents($group_id)
    {
        $group = $this->findGroup($this->institution, $group_id);

        return $this->studentService->getGroupStudents($group);
    }

    const actionCourses = 'courses';
    public function actionCourses()
    {
        // TODO pagination needed?
        $courses = $this->courseService->getCourses($this->institution);

        $result = [];
        foreach ($courses as $course) {
            $result[] = [
                'id' => $course->id,
                'caption' => $course->caption,
                'status' => $course->status,
                'create_ts' => $course->create_ts,
                'update_ts' => $course->update_ts,
                'delete_ts' => $course->delete_ts,
                'classes' => $course->classes,
                'teacherCourses' => $course->teacherCourses,
            ];
        }

        return $result;
    }

    const actionLessons = 'lessons';
    public function actionLessons($course_id, $teacher_course_id)
    {
        $course = $this->findCourse($this->institution, $course_id);
        $teacherCourse = $this->findTeacherCourse($course, $teacher_course_id);

        return $this->lessonService->getTeacherCourseLessons($teacherCourse);
    }

    public function actionPostGrade($student_id, $lesson_id, $value)
    {
        $student = $this->studentService->getInstitutionStudent($this->institution, $student_id);
        $lesson = $this->findLesson($student, $lesson_id);

        $studentSessionGrade = new StudentSessionGrade();
        $studentSessionGrade->student_id = $student->id;
        $studentSessionGrade->lesson_id = $lesson->id;
        $studentSessionGrade->value = $value;

        return $this->studentGradeService->addStudentGrade($studentSessionGrade);
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

    protected function findGroup(Institution $institution, $id)
    {
        $group = $this->groupService->getGroup($institution, $id);
        if ($group !== null) {
            return $group;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function findLesson(Student $student, $id)
    {
        $lesson = $this->lessonService->getStudentLesson($student, $id);
        if ($lesson !== null) {
            return $lesson;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
