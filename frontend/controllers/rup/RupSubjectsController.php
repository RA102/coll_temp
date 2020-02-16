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
    public function actionCreateAjax()
    {
        $model = new RupSubjects();
        $model->code=Yii::$app->request->post('code');
        $model->rup_id=Yii::$app->request->post('rup_id');
        $model->name=Yii::$app->request->post('name');
        $model->eight_sem_time=Yii::$app->request->post('eight_sem_time');
        $model->seven_sem_time=Yii::$app->request->post('seven_sem_time');
        $model->six_sem_time=Yii::$app->request->post('six_sem_time');
        $model->five_sem_time=Yii::$app->request->post('five_sem_time');
        $model->four_sem_time=Yii::$app->request->post('four_sem_time');
        $model->three_sem_time=Yii::$app->request->post('three_sem_time');
        $model->two_sem_time=Yii::$app->request->post('two_sem_time');
        $model->one_sem_time=Yii::$app->request->post('one_sem_time');
        $model->production_practice_time=Yii::$app->request->post('production_practice_time');
        $model->lab_time=Yii::$app->request->post('lab_time');
        $model->teory_time=Yii::$app->request->post('teory_time');
        $model->time=Yii::$app->request->post('time');
        $model->offset=Yii::$app->request->post('offset');
        $model->control_work=Yii::$app->request->post('control_work');
        $model->exam=Yii::$app->request->post('exam');
        $model->id_block=Yii::$app->request->post('id_block');
        $model->id_sub_block=Yii::$app->request->post('id_sub_block');
        if($model->save()){
            return "all good saved";
        }

    }
    public function actionUpdateSubject($id=null)
    {
        $modelId=Yii::$app->request->post('id');
        $model = RupSubjects::find()->where(['=','id',$modelId])->limit(1)->all();
        $model->code=Yii::$app->request->post('code');
        $model->rup_id=Yii::$app->request->post('rup_id');
        $model->name=Yii::$app->request->post('name');
        $model->eight_sem_time=Yii::$app->request->post('eight_sem_time');
        $model->seven_sem_time=Yii::$app->request->post('seven_sem_time');
        $model->six_sem_time=Yii::$app->request->post('six_sem_time');
        $model->five_sem_time=Yii::$app->request->post('five_sem_time');
        $model->four_sem_time=Yii::$app->request->post('four_sem_time');
        $model->three_sem_time=Yii::$app->request->post('three_sem_time');
        $model->two_sem_time=Yii::$app->request->post('two_sem_time');
        $model->one_sem_time=Yii::$app->request->post('one_sem_time');
        $model->production_practice_time=Yii::$app->request->post('production_practice_time');
        $model->lab_time=Yii::$app->request->post('lab_time');
        $model->teory_time=Yii::$app->request->post('teory_time');
        $model->time=Yii::$app->request->post('time');
        $model->offset=Yii::$app->request->post('offset');
        $model->control_work=Yii::$app->request->post('control_work');
        $model->exam=Yii::$app->request->post('exam');
        $model->id_block=Yii::$app->request->post('id_block');
        $model->id_sub_block=Yii::$app->request->post('id_sub_block');
        if($model->save()){
            return "all good saved";
        }
        elseif (!$model->save){
//            return var_dump($model->errors);
            return $model;
        }

    }
    public function actionUpdateSubjectt($id)
    {
//        $modelId=$id;
//        $model = RupSubjects::find()->where(['=','id',$modelId])->limit(1)->all();
        $model = $this->findModel($id);
        $model->code=Yii::$app->request->get('code');
        $model->rup_id=Yii::$app->request->get('rup_id');
        $model->name=Yii::$app->request->get('name');
        $model->eight_sem_time=Yii::$app->request->get('eight_sem_time');
        $model->seven_sem_time=Yii::$app->request->get('seven_sem_time');
        $model->six_sem_time=Yii::$app->request->get('six_sem_time');
        $model->five_sem_time=Yii::$app->request->get('five_sem_time');
        $model->four_sem_time=Yii::$app->request->get('four_sem_time');
        $model->three_sem_time=Yii::$app->request->get('three_sem_time');
        $model->two_sem_time=Yii::$app->request->get('two_sem_time');
        $model->one_sem_time=Yii::$app->request->get('one_sem_time');
        $model->production_practice_time=Yii::$app->request->get('production_practice_time');
        $model->lab_time=Yii::$app->request->get('lab_time');
        $model->teory_time=Yii::$app->request->get('teory_time');
        $model->time=Yii::$app->request->get('time');
        $model->offset=Yii::$app->request->get('offset');
        $model->control_work=Yii::$app->request->get('control_work');
        $model->exam=Yii::$app->request->get('exam');
        $model->id_block=Yii::$app->request->get('id_block');
//        $model->id_sub_block=Yii::$app->request->get('id_sub_block');
        if($model->save()){
            return "all good saved";
        }
        elseif (!$model->save){
//            return var_dump($model->errors);
            return var_dump($model);
        }

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
        $info = RupSubjects::find()
            ->joinWith(['block','subBlock'])
            ->where(['rup_subjects.id'=>$id])
            ->asArray()
            ->one();
//        $info = $this->findModel($id);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $info;
    }
    public function actionDeleteModule($id)
    {
//        $info = RupSubjects::findOne($id);
        $info = $this->findModel($id);
        $info->id_sub_block=0;
        $info->rup_id=0;
        if($info->save()){
            return true;
    }
        else{
            return false;
        }
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
