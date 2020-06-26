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

use common\helpers\GroupHelper;
use common\helpers\LanguageHelper;
use common\models\Nationality;
use common\models\organization\Group;
use common\models\organization\InstitutionDiscipline;
use frontend\search\GroupSearch;
use Yii;
// use app\models\rup\RupRoots;
// use app\models\rup\RupRootsSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'returnjson'=>['POST'],
                    'get-specialities'=>['GET'],
                    'get-qualifications'=>['GET'],
                    'get-departments'=>['GET'],
                    
                     
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
        // $searchModel = new RupRootsSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $subjects = RupSubjects::find()->joinWith('subBlock')->joinWith('block')->orderBy('rup_block.id')->all();
        return $this->render('index', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
            // 'subjects'=>$subjects
        ]);
    }

    public function actionGetDepartments(){
        $deps = Nationality::find()->limit(10)->asArray()->all();
        return Json::encode($deps);
    }

    public function actionGetGroups($department_id = "", $edu_form = '', $edu_lang = "", $curs = "")
    {
        $groups = Group::find()
            ->filterWhere(['institution_id' => Yii::$app->user->identity->institution->id])
            ->andFilterWhere(['department_id' => $department_id, 'education_form' => $edu_form, "language" => $edu_lang, "class" => $curs])
            ->asArray()
            ->all();
        return Json::encode($groups);

    }

    public function actionGetDisciplines($id = null)
    {
        $disciplines = InstitutionDiscipline::find()
            ->filterWhere(['institution_id' => Yii::$app->user->identity->institution->id, 'department_id' => $id])
            ->asArray()
            ->all();
        return Json::encode($disciplines);
    }

    /**
     * @param $id => group_id
     */
    public function actionGetEducationForm()
    {
        $eduForm = GroupHelper::getEducationFormList();
        return Json::encode($eduForm);
    }

    public function actionGetEduLangs()
    {
        return Json::encode(LanguageHelper::getLanguageList());
    }

    
    /**
     * Finds the RupRoots model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RupRoots the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // protected function findModel($id)
    // {
    //     if (($model = RupRoots::findOne($id)) !== null) {
    //         return $model;
    //     }

    //     throw new NotFoundHttpException('The requested page does not exist.');
    // }

    
}
