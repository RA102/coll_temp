<?php

namespace frontend\controllers;

use common\models\RequiredDisciplines;
use common\models\organization\Group;
use common\models\organization\Institution;
use common\models\organization\InstitutionDiscipline;
use common\models\person\Employee;
use common\services\organization\InstitutionDisciplineService;
use common\services\person\EmployeeService;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PlanController extends Controller
{
    private $institution;
    private $institutionDisciplineService;
    private $employeeService;

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
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function __construct(
        string $id,
        Module $module,
        InstitutionDisciplineService $institutionDisciplineService,
        EmployeeService $employeeService,
        array $config = []
    ) {
        $this->institutionDisciplineService = $institutionDisciplineService;
        $this->employeeService = $employeeService;
        parent::__construct($id, $module, $config);
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $this->institution = \Yii::$app->user->identity->institution;
        return true;
    }

    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }

    public function actionRequired()
    {
        $query = RequiredDisciplines::find()
                ->joinWith('institutionDiscipline')
                ->where([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('required',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateRequired()
    {
        $model = new RequiredDisciplines();

        $institutionDisciplines = $this->institutionDisciplineService->getInstitutionDisciplines($this->institution);
        $groups = Group::find()->where(['institution_id' => $this->institution->id])->all();
        $teachers = $this->employeeService->getTeachers($this->institution);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['required']);
        }

        return $this->render('required/create', [
            'model' => $model,
            'institutionDisciplines' => $institutionDisciplines,
            'groups' => $groups,
            'teachers' => $teachers,
        ]);
    }

    public function actionViewRequired($id)
    {
        $model = RequiredDisciplines::findOne($id);

        return $this->render('required/view', [
            'model' => $model,
        ]);
    }

    public function actionOptional()
    {
        return $this->render('optional',[
        ]);
    }
}
