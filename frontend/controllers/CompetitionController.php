<?php

namespace frontend\controllers;

use common\services\organization\GroupService;
use common\services\reception\CommissionService;
use common\services\reception\CompetitionService;
use frontend\models\forms\CompetitionEntrantsForm;
use frontend\models\forms\EnlistEntrantForm;
use yii\base\Module;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CompetitionController extends Controller
{
    private $commissionService;
    private $competitionService;
    private $groupService;

    /**
     * CompetitionController constructor.
     * @param string $id
     * @param Module $module
     * @param array $config
     * @param CommissionService $commissionService
     * @param CompetitionService $competitionService
     * @param GroupService $groupService
     * @internal param $CommissionService
     * @internal param AdmissionApplicationService $admissionApplicationService
     */
    public function __construct(
        $id,
        Module $module,
        array $config = [],
        CommissionService $commissionService,
        CompetitionService $competitionService,
        GroupService $groupService
    ) {
        parent::__construct($id, $module, $config);

        $this->commissionService = $commissionService;
        $this->competitionService = $competitionService;
        $this->groupService = $groupService;
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
                        'actions' => [
                            'index',
                            'view'
                        ],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param int $commission_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex(int $commission_id)
    {
        $commission = $this->findCommission($commission_id);
        $competitions = $this->competitionService->getCompetitions($commission);
        $dataProvider = new ArrayDataProvider([
            'models' => $competitions
        ]);

        return $this->render('index', [
            'commission_id' => $commission_id,
            'dataProvider'  => $dataProvider
        ]);
    }

    /**
     * @param int $commission_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $commission_id)
    {
        $commission = $this->findCommission($commission_id);

        $params = \Yii::$app->request->getQueryParams();
        $competitionEntrantsForm = new CompetitionEntrantsForm();
        $competitionEntrantsForm->load($params);

        if (!$competitionEntrantsForm->validate()) {
            throw new NotFoundHttpException();
        }

        $admissionApplications = $this->competitionService->getAdmissionApplicationsForCompetition(
            $commission,
            $competitionEntrantsForm->speciality_id,
            $competitionEntrantsForm->education_pay_form,
            $competitionEntrantsForm->language,
            $competitionEntrantsForm->education_form,
            $competitionEntrantsForm->based_classes
        );

        $groups = $this->groupService->getAssociativeByClass(
            1,
            \Yii::$app->user->identity->institution->id,
            $competitionEntrantsForm->education_form,
            $competitionEntrantsForm->education_pay_form,
            $competitionEntrantsForm->speciality_id,
            $competitionEntrantsForm->language
        );

        return $this->render('view/view', [
            'admissionApplications'   => $admissionApplications,
            'commission'              => $commission,
            'competitionEntrantsForm' => $competitionEntrantsForm,
            'enlistEntrantForm'       => new EnlistEntrantForm(),
            'groups'                  => $groups
        ]);
    }

    /**
     * @param int $commission_id
     * @return array|\common\models\reception\Commission|null
     * @throws NotFoundHttpException
     */
    protected function findCommission(int $commission_id)
    {
        $commission = $this->commissionService->getInstitutionCommission(
            \Yii::$app->user->identity->institution,
            $commission_id
        );
        if (!$commission) {
            throw new NotFoundHttpException("Коммисия не найдена");
        }

        return $commission;
    }
}