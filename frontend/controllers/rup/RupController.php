<?php

namespace frontend\controllers\rup;

use common\models\organization\InstitutionDiscipline;
use common\services\person\EmployeeService;
use frontend\controllers\InstitutionDisciplineController;
use frontend\models\rup\RupBlock;
use frontend\models\rup\RupBlockSearch;
use frontend\models\rup\RupQualifications;
use frontend\models\rup\RupModule;
use frontend\models\rup\RupModuleSearch;
use frontend\models\rup\RupSubjects;
use frontend\models\rup\RupSubjectsSearch;
use Yii;
use app\models\rup\RupRoots;
use app\models\rup\RupRootsSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\handbook\Speciality;

use yii\helpers\Html;


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
                    'returnjson'=>['POST'],
                    'get-specialities'=>['GET'],
                    'get-qualifications'=>['GET'],
                    
                     
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

        $searchModel = new RupModuleSearch();
        $dataProvider = $searchModel->searchwithoutblock(Yii::$app->request->queryParams,$id);

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
        $profiles = Speciality::find()->where(['type' => '1'])->limit(200)->all();
        $code = '13';
        if ($profiles != null && count($profiles)>0){
            $code = $profiles[0]->code;
            $code = substr($code,0,2) . '%';
        }
        $specialities = Speciality::find()->select(["code", "caption"])->where(['type' => '3'])->andWhere(['like', 'code', $code, false])->all();
        //$specialities = $this->actionGetSpecialities('1300');

        return $this->render('create', [
            'model' => $model,
            'specialities'=>$specialities,
            'profiles' => $profiles,
        ]);
    }

    /**
     * Updates an existing RupRoots model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$active=1,$block_id=null)
    {
        $model = $this->findModel($id);
        $query=null;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'UPDATED';
        }

        $dataInstitutionDiscipline = new InstitutionDiscipline();
        $templates = InstitutionDiscipline::find()->all();
        $listData = ArrayHelper::map($templates, 'id', 'caption_ru');


        $searchModel = new RupModuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id,$block_id);

        $searchModelBlock = new RupBlockSearch();
        $dataProviderBlock = $searchModelBlock->search(Yii::$app->request->queryParams,$id);

        $specialities = $this->actionGetSpecialities($model->profile_code);
        $qualifications = RupQualifications::find()->where(['rup_id'=>$model->rup_id])
        //->innerJoin(Speciality::tableName(), Speciality::tableName() . ".code=" . RupQualifications::tableName() . ".qualification_code")
        //->select([RupQualifications::tableName() . ".qualification_code", RupQualifications::tableName() . ".time_years", RupQualifications::tableName() . ".time_months", Speciality::tableName() . ""])
        ->asArray()->all();

        $model_2 = new InstitutionDiscipline();
        $institution = \Yii::$app->user->identity->institution;
        $employeeService = new EmployeeService();
        $employeeService->getTeachersActive($institution);

        return $this->render('update', [
            'active'=>$active,
            'model' => $model,
            'qualifications'=>$qualifications,
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
            'searchModelBlock'=>$searchModelBlock,
            'dataProviderBlock'=>$dataProviderBlock,

            'dataInstitutionDiscipline' => $dataInstitutionDiscipline,
            'templates' => $templates,
            'listData' => $listData,
            'model_2' => $model_2,
            'teachers' => $employeeService->getTeachersActive($institution),

            'specialities'=>$specialities,

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
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->status = RupRoots::STATUS_DELETED;
        $model->save();

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

    public function actionCreateDiscipline()
    {
        //$discipline = new InstitutionDisciplineController();
        //$discipline->createAction();
        $model = new InstitutionDiscipline();
        $employeeService = new EmployeeService();
        $institution = \Yii::$app->user->identity->institution;


        return $this->renderAjax('createDiscipline', [
        'model' => $model,
        'teachers' => $employeeService->getTeachers($institution),
        ]);
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

    public function actionGetSpecialities($parent_code){
        $code = substr($parent_code,0,2) . '%';
        $sp = Speciality::find()->select(["code", "caption"])->where(['type' => '2'])->andWhere(['like', 'code', $code, false])->all();
        $data = ArrayHelper::toArray($sp, [
            'common\models\handbook\Speciality' => [
                'code',
                
                'caption' => function ($Speciality) {
                    return $Speciality->getCaptionWithCode();
                },
            ],
        ]);

        $result="";
        //return Json::encode($data);
        foreach($data as $value=>$spec){
            $result = $result . '<option value="'. $spec['code'] . '"> ' . $spec['caption'] .'</option>';

        }
        return $result;
    }

    public function actionGetQualifications($parent_code){
        $code = substr($parent_code,0,4) . '%';
        $sp = Speciality::find()->select(["code", "caption"])->where(['type' => '3'])->andWhere(['like', 'code', $code, false])->all();
        $data = ArrayHelper::toArray($sp, [
            'common\models\handbook\Speciality' => [
                'code',
                
                'caption' => function ($Speciality) {
                    return $Speciality->getCaptionWithCode();
                },
            ],
        ]);

        $result="";
        //return Json::encode($data);
        foreach($data as $value=>$spec){
            $result = $result . '<option value="'. $spec['code'] . '"> ' . $spec['caption'] .'</option>';

        }
        return $result;
    }    
}
