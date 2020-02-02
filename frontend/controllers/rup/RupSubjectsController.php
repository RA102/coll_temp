<?php

namespace frontend\controllers\rup;

use Yii;
use frontend\models\rup\RupSubjects;
use frontend\models\rup\RupSubjectsSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RupSubjectsSearchController implements the CRUD actions for RupSubjects model.
 */
class RupSubjectsController extends Controller
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

    /**
     * Lists all RupSubjects models.
     * @return mixed
     */
    public function actionIndex($rup_id)
    {
        $searchModel = new RupSubjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$rup_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexTab($rup_id)
    {
//        $this->layout = 'exit';
        $searchModel = new RupSubjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$rup_id);
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $render=$this->renderPartial('indextab', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        return Json::encode($render);
    }

    /**
     * Displays a single RupSubjects model.
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
     * Creates a new RupSubjects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RupSubjects();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RupSubjects model.
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
        $searchModel = new RupSubjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('update', [
            'model' => $model,
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider
        ]);
    }

    /**
     * Deletes an existing RupSubjects model.
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
    public function actionGetInfo($id)
    {
        $info = $this->findModel($id);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $info;
    }

    /**
     * Finds the RupSubjects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RupSubjects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RupSubjects::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
