<?php

namespace frontend\controllers;

use common\models\person\Entrant;
use common\models\organization\Classroom;
use common\models\organization\Stats;
use frontend\search\ClassroomSearch;
use common\models\person\Person;
use common\models\person\Student;
use common\services\organization\GroupService;
use common\services\person\PersonService;
use common\services\reception\CommissionService;
use frontend\models\forms\GroupAllocationForm;
use frontend\search\StudentSearch;
use frontend\search\EntrantSearch;use Yii;
use common\models\organization\Group;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class StatsController extends Controller
{
    public $groupService;
    private $personService;
    protected $commissionService;

    public function __construct(string $id, $module, GroupService $groupService, PersonService $personService, CommissionService $commissionService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->groupService = $groupService;
        $this->personService = $personService;
        $this->commissionService = $commissionService;
    }

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

    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $institution = Yii::$app->user->identity->institution;

        $total = $institution->students;
        $total_male = $institution->studentsMale;
        $total_female = $institution->studentsFemale;

        // Entrants
        $activeCommission = $this->commissionService->getActiveInstitutionCommission(
            Yii::$app->user->identity->institution
        );
        $searchModel = new EntrantSearch($activeCommission);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $entrants = $dataProvider->getCount();

        $searchModel = new EntrantSearch($activeCommission);
        $searchModel->sex = Person::SEX_MALE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $entrants_male = $dataProvider->getCount();

        $searchModel = new EntrantSearch($activeCommission);
        $searchModel->sex = Person::SEX_FEMALE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $entrants_female = $dataProvider->getCount();


        return $this->render('index', [
            'institution' => $institution,
            'total' => $total,
            'total_male' => $total_male,
            'total_female' => $total_female,
            'entrants' => $entrants,
            'entrants_male' => $entrants_male,
            'entrants_female' => $entrants_female,
        ]);
    }

}
