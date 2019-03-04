<?php

namespace frontend\controllers;

use common\services\organization\InstitutionDisciplineService;
use common\services\TeacherCourseService;
use frontend\search\TeacherCourseSearch;
use Yii;
use common\models\Course;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class CourseController extends Controller
{
    private $institution;
    private $institutionDisciplineService;
    private $teacherCourseService;

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
                            'index', 'view',
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

    public function __construct(
        string $id,
        Module $module,
        InstitutionDisciplineService $institutionDisciplineService,
        TeacherCourseService $teacherCourseService,
        array $config = []
    ) {
        $this->institution = \Yii::$app->user->identity->institution;
        $this->institutionDisciplineService = $institutionDisciplineService;
        $this->teacherCourseService = $teacherCourseService;
        parent::__construct($id, $module, $config);
    }

    /**
     * Lists all Course models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Course::find()->with([
                'institutionDiscipline' /** @see Course::getInstitutionDiscipline() */
            ]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single Course model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $teacherCourseSearchModel = new TeacherCourseSearch();

        $teacherCourseSearchModel->load(Yii::$app->request->queryParams);
        $teacherCourseSearchModel->course_id = $id;
        $teacherCourseDataProvider = $teacherCourseSearchModel->search();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'teacherCourseDataProvider' => $teacherCourseDataProvider,
            'teacherCourseSearchModel' => $teacherCourseSearchModel,
        ]);
    }

    /**
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Course();

        $institutionDisciplines = $this->institutionDisciplineService->getInstitutionDisciplines($this->institution);

        $classes = [];
        for ($i = 1; $i <= $this->institution->max_grade; $i++) {
            $classes[$i] = $i;
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'institutionDisciplines' => $institutionDisciplines,
            'classes' => $classes,
        ]);
    }

    /**
     * Updates an existing Course model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $institutionDisciplines = $this->institutionDisciplineService->getInstitutionDisciplines($this->institution);

        $classes = [];
        for ($i = 1; $i <= $this->institution->max_grade; $i++) {
            $classes[$i] = $i;
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'institutionDisciplines' => $institutionDisciplines,
            'classes' => $classes,
        ]);
    }

    /**
     * Deletes an existing Course model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
