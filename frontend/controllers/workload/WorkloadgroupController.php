<?php

namespace frontend\controllers\workload;

// use common\models\organization\InstitutionDiscipline;
// use common\services\person\EmployeeService;
// use frontend\controllers\InstitutionDisciplineController;
// use frontend\models\rup\RupBlock;
// use frontend\models\rup\RupBlockSearch;
// use frontend\models\rup\RupQualifications;
// use frontend\models\rup\RupModule;
// use frontend\models\rup\RupModuleSearch;
// use frontend\models\rup\RupSubjects;
// use frontend\models\rup\RupSubjectsSearch;

//use common\models\Nationality;

use common\models\Nationality;
use frontend\models\workload\WorkloadDiscipline;
use frontend\models\workload\WorkloadTeacher;
use Yii;
// use app\models\rup\RupRoots;
// use app\models\rup\RupRootsSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\rup\RupSubjects;

//use common\models\handbook\Speciality;

use yii\helpers\Html;

/**
 * RupController implements the CRUD actions for RupRoots model.
 */
class WorkloadgroupController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'index', 'view',
                            'create', 'update',
                            'delete'
                            , 'get-departments','get-discipline-load-row', 'get-group-load-row', 'get-teacher-load-row'=>['GET'],
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'returnjson'=>['POST'],
                    'get-specialities'=>['GET'],
                    'get-qualifications'=>['GET'],
                    'get-departments'=>['GET'],
                    
                    'get-discipline-load-row'=>['GET'],
                    'get-group-load-row'=>['GET'],
                    'get-teacher-load-row'=>['GET'],
                    
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

         //$searchModel = new WorkloadDiscipline();


        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $subjects = RupSubjects::find()->joinWith('subBlock')->joinWith('block')->orderBy('rup_block.id')->all();
        return $this->render('index');
        //, [
          //   'searchModel' => $searchModel,
//             'dataProvider' => $dataProvider,
//             'subjects'=>$subjects
       // ]);
    }

    public function actionGetDepartments(){
       $deps = Nationality::find()->limit(10)->asArray()->all();
       return Json::encode($deps);
    }




    public function actionGetDisciplineLoadRow($rup_id, $disc_id, $group_id, $rup_block_id = null, $rup_module_id = null){
        $groups = RupSubjects::find()->where(['rup_id' => $rup_id])
        ->limit(3)->asArray()->all();
        
        return Json::encode($groups);
    }

    public function actionGetGroupLoadRow($rup_id, $disc_id, $group_id, $rup_block_id = null, $rup_module_id = null){
        $groups = RupSubjects::find()->where(['rup_id' => $rup_id])
        ->limit(10)->asArray()->all();
        
        return Json::encode($groups);
    }
    
    public function actionTeacherLoadRow($rup_id, $disc_id, $group_id, $rup_block_id = null, $rup_module_id = null){
        $groups = RupSubjects::find()->where(['rup_id' => $rup_id])
        ->limit(10)->asArray()->all();
        
        return Json::encode($groups);
    }    

    /**
     * Creates a new InstitutionDiscipline model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new WorkloadTeacher();

    //     $subjectRow = Yii::$app->request->post();
    //     if ($model->load(Yii::$app->request->post())) {
    //         if ($model->save()) {
    //             if ($model->saveSubRow($subjectRow)) {
    //                 return $this->redirect(['index', 'id' => $model->id]);
    //             }
    //             return $this->redirect(['index', 'id' => $model->id]);
    //         }
    //     }

    //     return $this->render('index', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Updates an existing InstitutionDiscipline model.
    //  * If update is successful, the browser will be redirected to the 'view' page.
    //  * @param integer $id
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if(Yii::$app->request->isPost)
    //     {
    //         $subjectRow = Yii::$app->request->post();
    //         if ($model->saveSubRow($subjectRow)) {
    //             return $this->redirect(['index', 'id' => $model->id]);
    //         }
    //         if ($model->load(Yii::$app->request->post())) {
    //             $model->institution_id = Yii::$app->user->identity->institution->id;
    //             if ($model->save()) {
    //                 return $this->redirect(['index', 'id' => $model->id]);
    //             }
    //         }
    //     }

    //     return $this->render('index', [
    //         'model' => $model,
    //     ]);
    // }
    // /**
    //  * Deletes an existing InstitutionDiscipline model.
    //  * If deletion is successful, the browser will be redirected to the 'index' page.
    //  * @param integer $id
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id);
    //     return $this->redirect(['index']);
    // }
    // /**
    //  * Finds the RupRoots model based on its primary key value.
    //  * If the model is not found, a 404 HTTP exception will be thrown.
    //  * @param integer $id
    //  * @return WorkloadTeacher the loaded model
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    //  protected function findModel($id)
    //  {
    //      if (($model = WorkloadTeacher::findOne($id)) !== null) {
    //          return $model;
    //      }

    //      throw new NotFoundHttpException('The requested page does not exist.');
    //  }

    
}
