<?php

namespace frontend\controllers\rup;

use frontend\models\rup\RupModule;
use frontend\models\rup\RupSubjects;
use Yii;
use frontend\models\rup\RupBlock;
use frontend\models\rup\RupBlockSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RupBlockController implements the CRUD actions for RupBlock model.
 */
class RupBlockController extends Controller
{



    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $this->enableCsrfValidation = false;
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function beforeAction($action) {
        if($action->id == 'createtemplate') {
            Yii::$app->request->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }


    /**
     * Lists all RupBlock models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RupBlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RupBlock model.
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
    public function actionUpdateInfo($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
       $model = $this->findModel($id);
        $model->code=Yii::$app->request->post('code');
        $model->name=Yii::$app->request->post('name');
        $model->time=Yii::$app->request->post('time');
        if($model->save()){
            return "all good saved";
        }
        elseif (!$model->save){
            return var_dump($model->errors);
        }
    }

    /**
     * Creates a new RupBlock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RupBlock();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $model->id;
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreatetemplate(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $block_id="asg";
        $id=Yii::$app->request->post('isTemplate');
        if (Yii::$app->request->isPost) {
            $code=Yii::$app->request->post('code');
            $rup_id=Yii::$app->request->post('rup_id');
            $name=Yii::$app->request->post('name');
            $modelTemplate = RupBlock::find()->where(['id'=>$id])->asArray()->limit(1)->all();
            $model = new RupBlock();
            $model->time=$modelTemplate[0]['time'];
            $model->code=$code;
            $model->rup_id=$rup_id;
            $model->name=$name;
            $model->isTemplate=false;
            $model->save(false);
            $block_id=$model->id;
        }



        $modules = RupModule::find()->where(['block_id'=>$id])->asArray()->all();
        foreach ($modules as $module){
            $rup_module = New RupModule();
            $rup_module->rup_id=Yii::$app->request->post('rup_id');
            $rup_module->code=$module['code'];
            $rup_module->name=$module['name'];
            $rup_module->time=$module['time'];
            $rup_module->block_id=$model->id;
            $rup_module->save(false);

            $rupSubjects = RupSubjects::find()->
            where(['id_sub_block'=>$module['id']])->asArray()
                ->all();
            foreach ($rupSubjects as $rup_subject){
                $rupSubjects = New RupSubjects();
                $rupSubjects->rup_id=Yii::$app->request->post('rup_id');
                $rupSubjects->id_sub_block=$rup_module->id;
                $rupSubjects->id_block=$block_id;
                $rupSubjects->exam=$rup_subject['exam'];
                $rupSubjects->control_work=$rup_subject['control_work'];
                $rupSubjects->offset=$rup_subject['offset'];
                $rupSubjects->time=$rup_subject['time'];
                $rupSubjects->teory_time=$rup_subject['teory_time'];
                $rupSubjects->lab_time=$rup_subject['lab_time'];
                $rupSubjects->production_practice_time=$rup_subject['production_practice_time'];
                $rupSubjects->one_sem_time=$rup_subject['one_sem_time'];
                $rupSubjects->two_sem_time=$rup_subject['two_sem_time'];
                $rupSubjects->three_sem_time=$rup_subject['three_sem_time'];
                $rupSubjects->four_sem_time=$rup_subject['four_sem_time'];
                $rupSubjects->five_sem_time=$rup_subject['five_sem_time'];
                $rupSubjects->six_sem_time=$rup_subject['six_sem_time'];
                $rupSubjects->seven_sem_time=$rup_subject['seven_sem_time'];
                $rupSubjects->eight_sem_time=$rup_subject['eight_sem_time'];
                $rupSubjects->name=$rup_subject['name'];
                $rupSubjects->code=$rup_subject['code'];
                $rupSubjects->save(false);
        }
        }
        return $rupSubjects;
    }

    /**
     * Updates an existing RupBlock model.
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
     * Deletes an existing RupBlock model.
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
    public function actionDeleteAjax($id)
    {
        $model = $this->findModel($id);
        $model->rup_id=0;
        if($model->save()){
            return "ok";
        };
    }

    /**
     * Finds the RupBlock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RupBlock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RupBlock::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
