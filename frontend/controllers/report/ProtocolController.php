<?php

namespace frontend\controllers\report;

use common\models\person\Person;
use common\models\reception\AdmissionProtocol;
use common\services\exceptions\DomainException;
use common\services\PdfService;
use common\services\person\EntrantService;
use common\services\reception\AdmissionProtocolService;
use common\services\reception\CommissionService;
use common\services\ReceptionGroupService;
use frontend\models\forms\AdmissionProtocolForm;
use frontend\models\reception\admission_protocol\ProtocolIssueForm;
use frontend\search\AdmissionProtocolSearch;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class ProtocolController extends \yii\web\Controller
{
    protected $institution;
    protected $admissionProtocolService;
    protected $commissionService;
    protected $entrantService;
    protected $pdfService;
    protected $receptionGroupService;

    /**
     * ProtocolController constructor.
     * @param string $id
     * @param Module $module
     * @param AdmissionProtocolService $admissionProtocolService
     * @param CommissionService $commissionService
     * @param EntrantService $entrantService
     * @param PdfService $pdfService
     * @param ReceptionGroupService $receptionGroupService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        AdmissionProtocolService $admissionProtocolService,
        CommissionService $commissionService,
        EntrantService $entrantService,
        PdfService $pdfService,
        ReceptionGroupService $receptionGroupService,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);

        $this->admissionProtocolService = $admissionProtocolService;
        $this->commissionService = $commissionService;
        $this->entrantService = $entrantService;
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
                            'view',
                            'create',
                            'update',
                            'delete',
                            'add-issue',
                            'delete-issue',
                            'print'
                        ],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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

        $searchModel = new AdmissionProtocolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'commission'   => $commission,
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    /**
     * @param int $commission_id
     * @return array|\common\models\reception\Commission|null
     * @throws NotFoundHttpException
     */
    public function findCommission(int $commission_id)
    {
        $commission = $this->commissionService->getInstitutionCommission(
            $this->institution,
            $commission_id
        );
        if (!$commission) {
            throw new NotFoundHttpException("Коммисия не найдена");
        }

        return $commission;
    }

    /**
     * Displays a single AdmissionProtocol model.
     * @param int $commission_id
     * @param integer $id
     * @return mixed
     */
    public function actionView(int $commission_id, int $id)
    {
        return $this->render('view', [
            'commission'        => $this->findCommission($commission_id),
            'admissionProtocol' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the AdmissionProtocol model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdmissionProtocol the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdmissionProtocol::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Creates a new AdmissionProtocol model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param int $commission_id
     * @return mixed
     */
    public function actionCreate(int $commission_id)
    {
        $commission = $this->findCommission($commission_id);
        $admissionProtocolForm = new AdmissionProtocolForm($commission_id);

        if ($admissionProtocolForm->load(Yii::$app->request->post()) && $admissionProtocolForm->validate()) {
            try {
                $admissionProtocol = $this->admissionProtocolService->create(
                    $commission,
                    $admissionProtocolForm
                );

                return $this->redirect(Url::current(['view', 'id' => $admissionProtocol->id]));
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->i18nMessageKey);
            }
        }

        return $this->render('create', [
            'admissionProtocolForm' => $admissionProtocolForm,
            'commission'            => $commission
        ]);
    }

    /**
     * Updates an existing AdmissionProtocol model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $commission_id
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate(int $commission_id, int $id)
    {
        $commission = $this->findCommission($commission_id);
        $admissionProtocol = $this->findModel($id);

        $admissionProtocolForm = new AdmissionProtocolForm($commission->id);
        $admissionProtocolForm->setAttributes($admissionProtocol->getAttributes());

        if ($admissionProtocolForm->load(Yii::$app->request->post()) && $admissionProtocolForm->validate()) {
            try {
                $admissionProtocol = $this->admissionProtocolService->update(
                    $admissionProtocol,
                    $admissionProtocolForm
                );

                return $this->redirect(['view', 'id' => $admissionProtocol->id, 'commission_id' => $commission_id]);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->i18nMessageKey);
            }
        }

        return $this->render('update', [
            'admissionProtocol'     => $admissionProtocol,
            'admissionProtocolForm' => $admissionProtocolForm,
            'commission'            => $commission,
        ]);
    }

    /**
     * @param int $commission_id
     * @param int $id
     * @return string
     */
    public function actionAddIssue(int $commission_id, int $id)
    {
        // NOTE: kind of permission validation to check access for given model
        $commission = $this->findCommission($commission_id);
        $admissionProtocol = $this->findModel($id);

        $protocolIssueForm = new ProtocolIssueForm();
        if ($protocolIssueForm->load(Yii::$app->request->post()) && $protocolIssueForm->validate()) {
            try {
                $this->admissionProtocolService->addIssue($admissionProtocol, $protocolIssueForm);
                return $this->redirect(['view', 'id' => $id, 'commission_id' => $commission_id]);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->i18nMessageKey);
            }
        }

        $receptionGroups = $this->receptionGroupService->getCommissionReceptionGroups($commission);

        return $this->render('issue_form', [
            'admissionProtocol' => $admissionProtocol,
            'commission'        => $commission,
            'protocolIssueForm' => $protocolIssueForm,
            'receptionGroups'   => $receptionGroups,
            'possibleSpeakers'  => $commission->members
        ]);
    }

    /**
     * @param int $commission_id
     * @param int $id
     * @param int $key
     * @return string
     */
    public function actionDeleteIssue(int $commission_id, int $id, int $key)
    {
        // NOTE: kind of permission validation to check access for given model
        $commission = $this->findCommission($commission_id);
        $admissionProtocol = $this->findModel($id);

        try {
            $this->admissionProtocolService->deleteIssue($admissionProtocol, $key);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->i18nMessageKey);
        }

        return $this->redirect(['view', 'id' => $id, 'commission_id' => $commission->id]);

    }

    /**
     * Deletes an existing AdmissionProtocol model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $commission_id
     * @param integer $id
     * @return mixed
     */
    public function actionDelete(int $commission_id, int $id)
    {
        $commission = $this->findCommission($commission_id);
        $admissionProtocol = $this->findModel($id);

        try {
            $this->admissionProtocolService->delete($admissionProtocol);
            return $this->redirect(['view', 'id' => $id, 'commission_id' => $commission->id]);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->i18nMessageKey);
        }

        return $this->redirect(['index']);
    }

    /**
     * Closes an existing AdmissionProtocol model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $commission_id
     * @param integer $id
     * @return mixed
     */
    public function actionClose(int $commission_id, int $id)
    {
        $commission = $this->findCommission($commission_id);
        $admissionProtocol = $this->findModel($id);

        try {
            $this->admissionProtocolService->close($admissionProtocol);
            return $this->redirect(['view', 'id' => $id, 'commission_id' => $commission->id]);
        } catch (DomainException $e) {
            Yii::$app->session->setFlash('error', $e->i18nMessageKey);
        }

        return $this->redirect(['index']);
    }

    /**
     * Prints an existing AdmissionProtocol model.
     * @param int $commission_id
     * @param integer $id
     * @return mixed
     */
    public function actionPrint(int $commission_id, int $id)
    {
        $commission = $this->findCommission($commission_id);
        $admissionProtocol = $this->findModel($id);

        $uniquePersonIds = array_unique(
            array_reduce(
                $admissionProtocol->issues,
                function (array $result, array $issue) {
                    return array_merge($result, $issue['listeners'], $issue['speakers']);
                },
                $admissionProtocol->commission_members->getValue()
            )
        );
        $uniqueParticipants = Person::find()->where(['id' => $uniquePersonIds])->indexBy('id')->all();

        $htmlDocument = $this->renderPartial('print', [
            'admissionProtocol'  => $admissionProtocol,
            'institution'        => $this->institution,
            'uniqueParticipants' => $uniqueParticipants
        ]);

        $pdf = $this->pdfService->generate(
            $htmlDocument,
            Yii::t('app', 'Protocol №{number}', ['number' => $admissionProtocol->number])
        );

        return $pdf->render();
    }
}