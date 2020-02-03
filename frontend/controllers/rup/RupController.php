<?php

namespace frontend\controllers\rup;

use frontend\models\rup\RupQualifications;
use frontend\models\rup\RupSubBlock;
use frontend\models\rup\RupSubBlockSearch;
use frontend\models\rup\RupSubjects;
use frontend\models\rup\RupSubjectsSearch;
use Yii;
use app\models\rup\RupRoots;
use app\models\rup\RupRootsSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RupController implements the CRUD actions for RupRoots model.
 */
class RupController extends Controller
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
                    'returnjson'=>['POST']
                ],
            ],
        ];
    }

    public $enableCsrfValidation = false;

    /**
     * Lists all RupRoots models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RupRootsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $subjects = RupSubjects::find()->joinWith('subBlock')->joinWith('block')->orderBy('rup_block.id')->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'subjects'=>$subjects
        ]);
    }

    /**
     * Displays a single RupRoots model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $searchModel = new RupSubBlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        $qualifications = RupQualifications::find()->where(['rup_id'=>$model->rup_id])->asArray()->all();

        return $this->render('viewrup', [
            'model' => $model,
            'qualifications'=>$qualifications,
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider
        ]);
    }

    /**
     * Creates a new RupRoots model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RupRoots();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->rup_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RupRoots model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$active=1)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'UPDATED';
        }

        $searchModel = new RupSubBlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        $qualifications = RupQualifications::find()->where(['rup_id'=>$model->rup_id])->asArray()->all();

        return $this->render('update', [
            'active'=>$active,
            'model' => $model,
            'qualifications'=>$qualifications,
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider
        ]);
    }

    /**
     * Deletes an existing RupRoots model.
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


    public function actionReturnjson()
    {
        $this->enableCsrfValidation = false;
        if (Yii::$app->request->isAjax){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $html = array(1=>2,2=>3,4=>5);
            return Json::encode($html);
        }

    }

    /**
     * Finds the RupRoots model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RupRoots the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RupRoots::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
