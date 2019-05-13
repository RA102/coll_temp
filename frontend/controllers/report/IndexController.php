<?php

namespace frontend\controllers\report;

use common\models\handbook\Speciality;
use common\models\link\CommissionMemberLink;
use common\services\PdfService;
use common\services\person\EntrantService;
use common\services\reception\CommissionService;
use common\services\ReceptionGroupService;
use frontend\models\forms\EntranceExamsReportForm;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class IndexController extends Controller
{
    protected $institution;
    protected $commissionService;
    protected $entrantsService;
    protected $receptionGroupService;
    protected $pdfService;

    /**
     * ReportController constructor.
     * @param string $id
     * @param Module $module
     * @param CommissionService $commissionService
     * @param EntrantService $entrantService
     * @param PdfService $pdfService
     * @param ReceptionGroupService $receptionGroupService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CommissionService $commissionService,
        EntrantService $entrantService,
        PdfService $pdfService,
        ReceptionGroupService $receptionGroupService,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);

        $this->commissionService = $commissionService;
        $this->entrantsService = $entrantService;
        $this->pdfService = $pdfService;
        $this->receptionGroupService = $receptionGroupService;
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->institution = \Yii::$app->user->identity->institution;
            return true;
        }

        return false;
    }

    /**
     * @return array
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
                            'forms',
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
     */
    public function actionIndex(int $commission_id)
    {
        $commission = $this->findCommission($commission_id);

        return $this->render('index', [
            'commission' => $commission
        ]);
    }

    /**
     * @param int $id
     * @return array|\common\models\reception\Commission|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    public function findCommission(int $id)
    {
        $commission = $this->commissionService->getInstitutionCommission(
            $this->institution,
            $id
        );
        if (!$commission) {
            throw new NotFoundHttpException("Коммисия не найдена");
        }

        return $commission;
    }

    /**
     * @param int $commission_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionForms(int $commission_id)
    {
        $commission = $this->findCommission($commission_id);
        $entranceExamsReportForm = new EntranceExamsReportForm();

        if ($entranceExamsReportForm->load(\Yii::$app->request->post()) &&
            $entranceExamsReportForm->validate()) {

            try {
                $receptionGroup = $this->receptionGroupService->findCommissionReceptionGroupByExamType(
                    $commission->id,
                    $entranceExamsReportForm->speciality_id,
                    $entranceExamsReportForm->education_form,
                    $entranceExamsReportForm->language,
                    $entranceExamsReportForm->exam_types
                );
                if (!$receptionGroup) {
                    throw new \DomainException('Группа с такими данными не найдена');
                }
                $entrants = $this->entrantsService->getEntrantsForEntranceExamsReport(
                    $receptionGroup,
                    $entranceExamsReportForm->education_pay_form,
                    $entranceExamsReportForm->based_classes
                );
                if (sizeof($entrants) == 0) {
                    throw new \DomainException('Заявки не найдены');
                }

                $secretaries = $this->commissionService->getCommissionMembers($commission,
                    [
                        CommissionMemberLink::ROLE_COMMISSION_SECRETARY
                    ]
                );

                $htmlDocument = $this->renderPartial("forms/form_{$entranceExamsReportForm->type}", [
                    'entranceExamsReportForm' => $entranceExamsReportForm,
                    'entrants'                => $entrants,
                    'secretary'               => $secretaries[0] ?? null,
                    'speciality'              => Speciality::findOne(['id' => $entranceExamsReportForm->speciality_id]),
                    'receptionGroup'          => $receptionGroup,
                ]);

                $pdf = $this->pdfService->generate(
                    $htmlDocument,
                    \Yii::t('app', 'Forms')
                );

                return $pdf->render();
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('forms', [
            'commission'              => $commission,
            'entranceExamsReportForm' => $entranceExamsReportForm,
            'specialities'            => \Yii::$app->user->identity->institution->specialities
        ]);
    }
}