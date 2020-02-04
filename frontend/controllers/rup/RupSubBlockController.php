<?php

namespace frontend\controllers\rup;

use frontend\models\rup\RupSubjects;
use Yii;
use frontend\models\rup\RupSubBlock;
use frontend\models\rup\RupSubBlockSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RupSubBlockController implements the CRUD actions for RupSubBlock model.
 */
class RupSubBlockController extends Controller
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
        $searchModel = new RupSubBlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$rup_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndexView($rup_id)
    {
        $searchModel = new RupSubBlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$rup_id);

        return $this->render('index', [
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
        $model = new RupSubBlock();

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

    public function actionSubjectsDetail() {
        if (isset($_POST['expandRowKey'])) {
//            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $subject = $this->findModel($_POST['expandRowKey']);
            $subjects = RupSubjects::find()->Where(['rup_subjects.id_sub_block'=>$_POST['expandRowKey']])->asArray()->joinWith('subBlock')->joinWith('block')->orderBy(['rup_block.id'=>SORT_ASC,'rup_sub_block.id'=>SORT_ASC])->all();
            return $this->renderPartial('/rup/rup-subjects/indexSubjects',['all'=>$subjects]);
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
     * @return RupSubBlock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RupSubBlock::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
