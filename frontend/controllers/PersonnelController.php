<?php

namespace frontend\controllers;

use common\models\RequiredDisciplines;
use common\models\OptionalDisciplines;
use common\models\Exams;
use common\models\Ktp;
use common\models\organization\Group;
use common\models\organization\Institution;
use common\models\organization\InstitutionDiscipline;
use common\models\person\Employee;
use common\models\person\Student;
use common\services\organization\InstitutionDisciplineService;
use common\services\person\EmployeeService;
use frontend\search\GroupSearch;
use frontend\search\EmployeeSearch;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PersonnelController extends Controller
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

    public function actionRequiredGroup()
    {
        $searchModel = new GroupSearch();
        $searchModel->institution_id = Yii::$app->user->identity->institution->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('required/group', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRequiredGroupView($group_id)
    {
    	$required = RequiredDisciplines::find()
                ->where(['group_id' => $group_id])
                ->joinWith('institutionDiscipline')
                ->andWhere([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id])
                ->all();

        return $this->render('required/group-view', [
        	'required' => $required,
        ]);
    }

    public function actionRequiredDiscipline()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => InstitutionDiscipline::find()->andWhere([
                'institution_id' => $this->institution->id /** TODO @see InstitutionDisciplineService::getInstitutionDisciplines() */
            ])
        ]);

        return $this->render('required/discipline', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRequiredDisciplineView($discipline_id)
    {
    	$required = RequiredDisciplines::find()
                ->where([RequiredDisciplines::tableName().'.discipline_id' => $discipline_id])
                ->joinWith('institutionDiscipline')
                ->andWhere([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id])
                ->all();

        return $this->render('required/discipline-view', [
        	'required' => $required,
        ]);
    }

    public function actionRequiredTeacher()
    {
		$searchModel = new EmployeeSearch($this->institution);
        $searchModel->status = Employee::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('required/teacher', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);    }

    public function actionRequiredTeacherView($teacher_id)
    {
    	$required = RequiredDisciplines::find()
    			->where(['teacher_id' => $teacher_id])
                ->joinWith('institutionDiscipline')
                ->andWhere([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id])
                ->all();

        return $this->render('required/teacher-view', [
        	'required' => $required,
        ]);
    }

}
