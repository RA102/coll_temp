<?php

namespace frontend\controllers\rup;

use frontend\models\rup\RupBlock;
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $rup_id, null);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionUpdateInfo($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        $model->code = Yii::$app->request->post('code');
        $model->name = Yii::$app->request->post('name');
        $model->time = Yii::$app->request->post('time');
        if ($model->save()) {
            return "all good saved";
        } elseif (!$model->save) {
            return var_dump($model->errors);
        }
    }
    public function actionIndexView($rup_id)
    {
        $searchModel = new RupModuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $rup_id, null);

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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $rup_id, null);
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


    public function actionCreatetemplate(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id=Yii::$app->request->post('isTemplate');


        if (Yii::$app->request->isPost) {
            $block_id=Yii::$app->request->post('block_id');
            $code=Yii::$app->request->post('code');
            $rup_id=Yii::$app->request->post('rup_id');
            $name=Yii::$app->request->post('name');
            $modelTemplate = RupModule::find()->where(['id'=>$id])->asArray()->limit(1)->all();
            $model = new RupModule();
            $model->time=$modelTemplate[0]['time'];
            $model->code=$code;
            $model->rup_id=$rup_id;
            $model->block_id=$block_id;
            $model->name=$name;
            $model->isTemplate=false;
            $model->save(false);
            $sbb=$model->id;


            $rupSubjects = RupSubjects::find()->
            where(['id_sub_block'=>$id])->asArray()
                ->all();
            foreach ($rupSubjects as $rup_subject){
                $rupSubjects = New RupSubjects();
                $rupSubjects->rup_id=Yii::$app->request->post('rup_id');
                $rupSubjects->id_sub_block=$sbb;
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
        if ($rupSubjects == null){
            $rupSubjects = "success";
        }
        return $rupSubjects;
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

    public function actionDeleteModule($id)
    {
        $module = $this->findModel($id);
        $module->rup_id=0;
        if($module->save(false)){
            return "321";
        }
        else{
            return $module->errors();
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
