<?php

namespace frontend\controllers;

use common\services\organization\GroupService;
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
    private $competitionService;
    private $groupService;

    /**
     * CompetitionController constructor.
     * @param string $id
     * @param Module $module
     * @param array $config
     * @param CompetitionService $competitionService
     * @param GroupService $groupService
     * @internal param AdmissionApplicationService $admissionApplicationService
     */
    public function __construct(
        $id,
        Module $module,
        array $config = [],
        CompetitionService $competitionService,
        GroupService $groupService
    ) {
        parent::__construct($id, $module, $config);

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
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $commission_id = \Yii::$app->request->getQueryParam('commission_id', null);
        if (!$commission_id) {
            throw new NotFoundHttpException();
        }

        $competitions = $this->competitionService->getCompetitions();
        $dataProvider = new ArrayDataProvider([
            'models' => $competitions
        ]);

        return $this->render('index', [
            'commission_id' => $commission_id,
            'dataProvider'  => $dataProvider
        ]);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView()
    {
        $params = \Yii::$app->request->getQueryParams();
        $competitionEntrantsForm = new CompetitionEntrantsForm();
        $competitionEntrantsForm->load($params);

        if (!$competitionEntrantsForm->validate()) {
            throw new NotFoundHttpException();
        }

        $admissionApplications = $this->competitionService->getAdmissionApplicationsForCompetition(
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
            'enlistEntrantForm'       => new EnlistEntrantForm(),
            'competitionEntrantsForm' => $competitionEntrantsForm,
            'admissionApplications'   => $admissionApplications,
            'groups'                  => $groups
        ]);
    }
}