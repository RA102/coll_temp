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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function action01()
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


        return $this->render('01', [
            'institution' => $institution,
            'total' => $total,
            'total_male' => $total_male,
            'total_female' => $total_female,
            'entrants' => $entrants,
            'entrants_male' => $entrants_male,
            'entrants_female' => $entrants_female,
        ]);
    }

    /*public function action02()
    {
        $institution = Yii::$app->user->identity->institution;
        $specialities = $institution->specialities;

        $entrants = $institution->entrants;
        $entrants_female = $institution->entrantsFemale;

        return $this->render('02', [
            'institution' => $institution,
            'specialities' => $specialities,
            'entrants' => $entrants,
            'entrants_female' => $entrants_female,
        ]);
    }*/

    public function action02()
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


        return $this->render('01', [
            'institution' => $institution,
            'total' => $total,
            'total_male' => $total_male,
            'total_female' => $total_female,
            'entrants' => $entrants,
            'entrants_male' => $entrants_male,
            'entrants_female' => $entrants_female,
        ]);
    }

    public function action03()
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


        return $this->render('01', [
            'institution' => $institution,
            'total' => $total,
            'total_male' => $total_male,
            'total_female' => $total_female,
            'entrants' => $entrants,
            'entrants_male' => $entrants_male,
            'entrants_female' => $entrants_female,
        ]);
    }

    public function action04()
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


        return $this->render('01', [
            'institution' => $institution,
            'total' => $total,
            'total_male' => $total_male,
            'total_female' => $total_female,
            'entrants' => $entrants,
            'entrants_male' => $entrants_male,
            'entrants_female' => $entrants_female,
        ]);
    }

    public function action05()
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


        return $this->render('01', [
            'institution' => $institution,
            'total' => $total,
            'total_male' => $total_male,
            'total_female' => $total_female,
            'entrants' => $entrants,
            'entrants_male' => $entrants_male,
            'entrants_female' => $entrants_female,
        ]);
    }

    public function action06()
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


        return $this->render('01', [
            'institution' => $institution,
            'total' => $total,
            'total_male' => $total_male,
            'total_female' => $total_female,
            'entrants' => $entrants,
            'entrants_male' => $entrants_male,
            'entrants_female' => $entrants_female,
        ]);
    }

    public function action07()
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


        return $this->render('01', [
            'institution' => $institution,
            'total' => $total,
            'total_male' => $total_male,
            'total_female' => $total_female,
            'entrants' => $entrants,
            'entrants_male' => $entrants_male,
            'entrants_female' => $entrants_female,
        ]);
    }

    public function action08()
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


        return $this->render('01', [
            'institution' => $institution,
            'total' => $total,
            'total_male' => $total_male,
            'total_female' => $total_female,
            'entrants' => $entrants,
            'entrants_male' => $entrants_male,
            'entrants_female' => $entrants_female,
        ]);
    }

    public function action09()
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


        return $this->render('01', [
            'institution' => $institution,
            'total' => $total,
            'total_male' => $total_male,
            'total_female' => $total_female,
            'entrants' => $entrants,
            'entrants_male' => $entrants_male,
            'entrants_female' => $entrants_female,
        ]);
    }

    public function action10()
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


        return $this->render('01', [
            'institution' => $institution,
            'total' => $total,
            'total_male' => $total_male,
            'total_female' => $total_female,
            'entrants' => $entrants,
            'entrants_male' => $entrants_male,
            'entrants_female' => $entrants_female,
        ]);
    }

    public function action11()
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


        return $this->render('01', [
            'institution' => $institution,
            'total' => $total,
            'total_male' => $total_male,
            'total_female' => $total_female,
            'entrants' => $entrants,
            'entrants_male' => $entrants_male,
            'entrants_female' => $entrants_female,
        ]);
    }

    public function action12()
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


        return $this->render('01', [
            'institution' => $institution,
            'total' => $total,
            'total_male' => $total_male,
            'total_female' => $total_female,
            'entrants' => $entrants,
            'entrants_male' => $entrants_male,
            'entrants_female' => $entrants_female,
        ]);
    }

    public function action13()
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


        return $this->render('01', [
            'institution' => $institution,
            'total' => $total,
            'total_male' => $total_male,
            'total_female' => $total_female,
            'entrants' => $entrants,
            'entrants_male' => $entrants_male,
            'entrants_female' => $entrants_female,
        ]);
    }

    public function action14()
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


        return $this->render('01', [
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
