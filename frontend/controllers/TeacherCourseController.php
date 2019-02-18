<?php

namespace frontend\controllers;

use common\services\CourseService;
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

    public function __construct(
        string $id,
        Module $module,
        CourseService $courseService,
        TeacherCourseService $teacherCourseService,
        array $config = []
    ) {
        $this->courseService = $courseService;
        $this->teacherCourseService = $teacherCourseService;
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
        return $this->render('view', [
            'model' => $this->findModel($course_id, $id),
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
        $model = new TeacherCourse();

        if ($model->load(Yii::$app->request->post())) {
            $model->course_id = $course_id;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'course_id' => $course_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
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
        $model = $this->findModel($course_id, $id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'course_id' => $course_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
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
        $this->findModel($course_id, $id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TeacherCourse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param $course_id
     * @param integer $id
     * @return TeacherCourse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($course_id, $id)
    {
        $institution = \Yii::$app->user->identity->institution;

        if (($course = $this->courseService->getCourse($institution, $course_id)) !== null) {
            if (($teacherCourse = $this->teacherCourseService->getTeacherCourse($course, $id)) !== null) {
                return $teacherCourse;
            }
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
