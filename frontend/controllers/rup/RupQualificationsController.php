<?php

namespace frontend\controllers\rup;

use common\models\handbook\Speciality;
use Yii;
use frontend\models\rup\RupQualifications;
use frontend\models\rup\RupQualificationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RupQualificationsController implements the CRUD actions for RupQualifications model.
 */
class RupQualificationsController extends Controller
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
     * Lists all RupQualifications models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RupQualificationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RupQualifications model.
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
     * Creates a new RupQualifications model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RupQualifications();

        $loaded = $model->load(Yii::$app->request->post());

        $model->qualification_name = Speciality::find()->where(['code' => $model->qualification_code])->one()->getCaptionWithCode();
        $strlevel = substr($model->qualification_code, -1, 1);
        $model->q_level = "Установленный уровень";
        if ($model->qualification_code != null && $strlevel != null){
            switch ($strlevel) {
                case "2":
                    $model->q_level = "Повышенный уровень квалификации";
                    break;
                case "3":
                    $model->q_level = "Специалист среднего звена";
                    break;
                case "4":
                    $model->q_level = "Прикладной бакалавр";
                    break;
                default:
                    $model->q_level = "Установленный уровень";                
            }
        }
        $saved = $model->save();

        if ($loaded && $saved) {
            return 'CREATED';
        }

        return $this->render('create', [
            'model' => $model,
            //'parent_code' => $parent_code,
        ]);
    }

    /**
     * Updates an existing RupQualifications model.
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

    public function actionUpdateQual($id){
        $model = $this->findModel($id);
        $model->qualification_name=Yii::$app->request->post('name');
        $model->time_years=Yii::$app->request->post('year');
        $model->time_months=Yii::$app->request->post('month');
        $model->qualification_code=Yii::$app->request->post('code');
        $model->q_level=Yii::$app->request->post('level');
        if(Yii::$app->user->id==null){
            //throwException('Not user');
        }
        else{
            $model->save();
            return true;
        }

    }

    /**
     * Deletes an existing RupQualifications model.
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

    public function actionDeleteFromRup($id)
    {
        $model = $this->findModel($id);
        $model->rup_id=0;
        $model->save();
        return "Was Deleted";
    }

    /**
     * Finds the RupQualifications model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RupQualifications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RupQualifications::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
