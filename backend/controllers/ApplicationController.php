<?php

namespace backend\controllers;

use backend\models\forms\ApplicationForm;
use Yii;
use common\models\organization\InstitutionApplication;
use backend\search\InstitutionApplicationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\services\organization\InstitutionApplicationService;
use yii\base\Module;

/**
 * ApplicationController implements the CRUD actions for InstitutionApplication model.
 */
class ApplicationController extends Controller
{
    private $applicationService;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
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
        InstitutionApplicationService $applicationService,
        array $config = []
    ) {
        $this->applicationService = $applicationService;
        parent::__construct($id, $module, $config);
    }

    /**
     * Lists all InstitutionApplication models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InstitutionApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InstitutionApplication model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new InstitutionApplication model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InstitutionApplication();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing InstitutionApplication model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new ApplicationForm($model);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->applicationService->update($model, $form);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'form' => $form,
        ]);
    }

    /**
     * Deletes an existing InstitutionApplication model.
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
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        try {
            $this->applicationService->approve($model);
            Yii::$app->session->setFlash('success', "Заявка одобрена");
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', "Произошла ошибка при сохранении");
        }

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $this->applicationService->reject($model);
        Yii::$app->session->setFlash('warning', "Заявка отклонена");

        return $this->redirect(['index']);
    }

    /**
     * Finds the InstitutionApplication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InstitutionApplication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InstitutionApplication::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
