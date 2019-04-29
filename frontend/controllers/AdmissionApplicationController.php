<?php

namespace frontend\controllers;

use common\models\educational_process\AdmissionApplication;
use common\services\educational_process\AdmissionApplicationService;
use frontend\models\forms\AdmissionApplicationForm;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AdmissionApplicationController implements the CRUD actions for AdmissionApplication model.
 */
class AdmissionApplicationController extends Controller
{
    public $admissionApplicationService;

    /**
     * AdmissionApplicationController constructor.
     * @param string $id
     * @param Module $module
     * @param AdmissionApplicationService $admissionApplicationService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        AdmissionApplicationService $admissionApplicationService,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);

        $this->admissionApplicationService = $admissionApplicationService;
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
                            'index',
                            'view',
                            'create',
                            'update',
                            'delete',
                        ],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AdmissionApplication models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AdmissionApplication::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdmissionApplication model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the AdmissionApplication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdmissionApplication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdmissionApplication::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Creates a new AdmissionApplication model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $admissionApplicationForm = new AdmissionApplicationForm();

        if ($admissionApplicationForm->load(Yii::$app->request->post()) && $admissionApplicationForm->validate()) {
            $admissionApplication = $this->admissionApplicationService->create(
                $admissionApplicationForm,
                Yii::$app->user->identity->institution->id
            );

            return $this->redirect(['view', 'id' => $admissionApplication->id]);
        }

        return $this->render('create', [
            'admissionApplicationForm' => $admissionApplicationForm,
            'specialities'             => Yii::$app->user->identity->institution->specialities
        ]);
    }

    /**
     * Updates an existing AdmissionApplication model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $admissionApplication = $this->findModel($id);
        $admissionApplicationForm = new AdmissionApplicationForm($admissionApplication->properties);

        if ($admissionApplicationForm->load(Yii::$app->request->post()) && $admissionApplicationForm->validate()) {
            $admissionApplication = $this->admissionApplicationService->update(
                $admissionApplication->id,
                $admissionApplicationForm
            );
            return $this->redirect(['view', 'id' => $admissionApplication->id]);
        }

        return $this->render('update', [
            'admissionApplication'     => $admissionApplication,
            'admissionApplicationForm' => $admissionApplicationForm,
            'specialities'             => Yii::$app->user->identity->institution->specialities
        ]);
    }

    /**
     * Deletes an existing AdmissionApplication model.
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
}
