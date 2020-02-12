<?php

namespace frontend\controllers\rup;

use frontend\models\rup\RupSubjects;
use Yii;
use frontend\models\rup\RupModule;
use frontend\models\rup\RupModuleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RupSubBlockController implements the CRUD actions for RupSubBlock model.
 */
class RupModuleController extends Controller
{



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
    public $enableCsrfValidation = false;
    /**
     * Lists all RupSubBlock models.
     * @return mixed
     */
    public function actionIndex($rup_id)
    {
        $searchModel = new RupModuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$rup_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndexView($rup_id)
    {
        $searchModel = new RupModuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$rup_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAjaxView($rup_id)
    {
//        Yii::$app->assetManager->bundles = [
//            'yii\bootstrap\BootstrapPluginAsset' => false,
//            'yii\bootstrap\BootstrapAsset' => false,
//            'yii\web\JqueryAsset' => false,
//        ];
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $searchModel = new RupModuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$rup_id);
        return $this->renderPartial('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RupSubBlock model.
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
     * Creates a new RupSubBlock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RupModule();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/rup/rup/update', 'id' => $model->rup_id,'active'=>2]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RupSubBlock model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RupSubBlock model.
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

    public function actionGetmoduleinfo($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        return $model;
    }

    public function actionSubjectsDetail() {
        if (isset($_POST['expandRowKey'])) {
//            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $subject = $this->findModel($_POST['expandRowKey']);
            $subjects = RupSubjects::find()->Where(['rup_subjects.id_sub_block'=>$_POST['expandRowKey']])->asArray()->joinWith('subBlock')->joinWith('block')->orderBy(['rup_block.id'=>SORT_ASC,'rup_module.id'=>SORT_ASC])->all();
            return $this->renderPartial('/rup/rup-subjects/indexSubjects',['all'=>$subjects,'module_ID'=>$_POST['expandRowKey']]);
//            return $subject->rup_id;
        }

        else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }
    public function actionSubjectsDetailView() {
        if (isset($_POST['expandRowKey'])) {
//            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $subject = $this->findModel($_POST['expandRowKey']);
            $subjects = RupSubjects::find()->Where(['rup_subjects.id_sub_block'=>$_POST['expandRowKey']])->asArray()->joinWith('subBlock')->joinWith('block')->orderBy(['rup_block.id'=>SORT_ASC,'rup_sub_block.id'=>SORT_ASC])->all();
            return $this->renderPartial('/rup/rup-subjects/indexSubjectsView',['all'=>$subjects]);
//            return $subject->rup_id;
        }

        else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }


    /**
     * Finds the RupSubBlock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RupModule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RupModule::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
