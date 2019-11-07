<?php

namespace frontend\controllers;

use common\helpers\ApplicationHelper;
use common\models\handbook\Speciality;
use common\models\reception\AdmissionApplication;
use common\models\ReceptionGroup;
use common\services\PdfService;
use common\services\reception\AdmissionApplicationService;
use common\services\reception\CommissionService;
use app\models\link\EntrantReceptionGroupLink;
use frontend\models\forms\AdmissionApplicationForm;
use frontend\models\forms\EnlistEntrantForm;
use frontend\models\reception\admission_application\ChangeStatusForm;
use frontend\models\reception\admission_application\ReceiptForm;
use frontend\search\AdmissionApplicationSearch;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AdmissionApplicationController implements the CRUD actions for AdmissionApplication model.
 */
class AdmissionApplicationController extends Controller
{
    public $admissionApplicationService;
    public $commissionService;
    public $pdfService;

    /**
     * AdmissionApplicationController constructor.
     * @param string $id
     * @param Module $module
     * @param AdmissionApplicationService $admissionApplicationService
     * @param CommissionService $commissionService
     * @param PdfService $pdfService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        AdmissionApplicationService $admissionApplicationService,
        CommissionService $commissionService,
        PdfService $pdfService,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);

        $this->admissionApplicationService = $admissionApplicationService;
        $this->commissionService = $commissionService;
        $this->pdfService = $pdfService;
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
                            'view',
                            'create',
                            'update',
                            'delete',
                            'change-status',
                            'change-speciality',
                            'enlist',
                            'receipt'
                        ],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete'  => ['POST'],
                    'enlist'  => ['POST'],
                    'receipt' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all AdmissionApplication models.
     * @return mixed
     */
    public function actionIndex()
    {
        //echo INTL_ICU_VERSION; die();
        $commission = $this->commissionService->getActiveInstitutionCommission(
            Yii::$app->user->identity->institution
        );

        $searchModel = new AdmissionApplicationSearch($commission);
        $searchModel->status = ApplicationHelper::STATUS_CREATED;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel
        ]);
    }

    /**
     * Displays a single AdmissionApplication model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $receiptForm = new ReceiptForm();
        if ($model->receipt) {
            $receiptForm->setAttributes($model->receipt);
        }

        return $this->render('view/view', [
            'model'       => $model,
            'receiptForm' => $receiptForm
        ]);
    }

    /**
     * Finds the AdmissionApplication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdmissionApplication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdmissionApplication::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Creates a new AdmissionApplication model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $admissionApplicationForm = new AdmissionApplicationForm();

        if ($admissionApplicationForm->load(Yii::$app->request->post()) && $admissionApplicationForm->validate()) {
            $commission = $this->commissionService->getActiveInstitutionCommission(
                Yii::$app->user->identity->institution
            );
            if (!$commission) {
                Yii::$app->session->setFlash('error',
                    Yii::t('app', 'Необходимо создать текущую комиссию для приема завлений'));
            }

            $admissionApplication = $this->admissionApplicationService->create(
                $admissionApplicationForm,
                $commission->id,
                Yii::$app->user->identity->institution->id
            );

            return $this->redirect(['view', 'id' => $admissionApplication->id]);
        }

        return $this->render('create', [
            'admissionApplicationForm' => $admissionApplicationForm,
            'specialities'             => Yii::$app->user->identity->institution->specialities
        ]);
    }

    /**
     * Updates an existing AdmissionApplication model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $admissionApplication = $this->findModel($id);
        $admissionApplicationForm = new AdmissionApplicationForm($admissionApplication);
        $admissionApplicationForm->birth_date = date('d-m-Y', strtotime($admissionApplicationForm->birth_date));
        $admissionApplicationForm->application_date = date('d-m-Y', strtotime($admissionApplicationForm->application_date));
        //$admissionApplicationForm->contract_date = date('d-m-Y', strtotime($admissionApplicationForm->contract_date));

        if ($admissionApplicationForm->load(Yii::$app->request->post()) && $admissionApplicationForm->validate()) {
            $admissionApplication = $this->admissionApplicationService->update(
                $admissionApplication->id,
                $admissionApplicationForm
            );
            return $this->redirect(['view', 'id' => $admissionApplication->id]);
        }

        return $this->render('update', [
            'admissionApplication'     => $admissionApplication,
            'admissionApplicationForm' => $admissionApplicationForm,
            'specialities'             => Yii::$app->user->identity->institution->specialities
        ]);
    }

    public function actionChangeSpeciality($id)
    {
        $admissionApplication = $this->findModel($id);
        $admissionApplicationForm = new AdmissionApplicationForm($admissionApplication);
        $admissionApplicationForm->birth_date = date('d-m-Y', strtotime($admissionApplicationForm->birth_date));
        $admissionApplicationForm->application_date = date('d-m-Y', strtotime($admissionApplicationForm->application_date));
        //$admissionApplicationForm->contract_date = date('d-m-Y', strtotime($admissionApplicationForm->contract_date));

        if ($admissionApplicationForm->load(Yii::$app->request->post()) && $admissionApplicationForm->validate()) {
            $admissionApplication = $this->admissionApplicationService->update(
                $admissionApplication->id,
                $admissionApplicationForm
            );

            $entrantReceptionGroupLink = EntrantReceptionGroupLink::find()->where(['entrant_id' => $admissionApplication->person_id])->one();
            if (!empty($entrantReceptionGroupLink)) {
                $entrantReceptionGroupLink->delete();
            }
            return $this->redirect(['view', 'id' => $admissionApplication->id]);
        }

        return $this->render('change-speciality', [
            'admissionApplication'     => $admissionApplication,
            'admissionApplicationForm' => $admissionApplicationForm,
            'specialities'             => Yii::$app->user->identity->institution->specialities
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionChangeStatus($id)
    {
        $admissionApplication = $this->findModel($id);
        $changeStatusForm = new ChangeStatusForm();
        $changeStatusForm->setCurrentStatus($admissionApplication->status);
        $changeStatusForm->reason = $admissionApplication->reason;

        $entrantReception = EntrantReceptionGroupLink::find()->where(['entrant_id' => $admissionApplication->person_id])->one();
        if ($entrantReception !== null) {
            $changeStatusForm->reception_group_id = $entrantReception->reception_group_id;
        }

        if ($changeStatusForm->load(Yii::$app->request->post()) && $changeStatusForm->validate()) {
            //if ($admissionApplication->status != $changeStatusForm->status) {
                try{
                    $this->admissionApplicationService->changeStatus(
                        $id,
                        $changeStatusForm->status,
                        Yii::$app->user->identity,
                        $changeStatusForm->reception_group_id,
                        $changeStatusForm->reason
                    );
                } catch(\yii\db\Exception $e){
                    echo $e->getName() . '<br>';
                    echo $e->getCode() . '<br>';
                    echo $e->getLine();
                //Get the user-friendly name of this exception
                }
            //}
            return $this->redirect(['view', 'id' => $admissionApplication->id]);
        }

        $eligibleReceptionGroupsForEntrant = ReceptionGroup::find()
            ->andWhere([
                'speciality_id'  => $admissionApplication->properties['speciality_id'],
                'education_form' => $admissionApplication->properties['education_form'],
                'language'       => $admissionApplication->properties['language'],
                'commission_id'  => $admissionApplication->commission_id
            ])->all();
        return $this->render('change-status', [
            'admissionApplication' => $admissionApplication,
            'changeStatusForm'     => $changeStatusForm,
            'receptionGroups'      => $eligibleReceptionGroupsForEntrant
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionEnlist()
    {
        $enlistAdmissionApplicationForm = new EnlistEntrantForm();

        if ($enlistAdmissionApplicationForm->load(Yii::$app->request->post())
            && $enlistAdmissionApplicationForm->validate()) {
            $this->admissionApplicationService->enlist(
                $enlistAdmissionApplicationForm->admission_application_id,
                $enlistAdmissionApplicationForm->group_id
            );

            Yii::$app->session->setFlash('success', Yii::t('app', 'Студент успешно зачислен'));
            return $this->redirect(Yii::$app->request->referrer);
        }

        Yii::$app->session->setFlash('error', current($enlistAdmissionApplicationForm->firstErrors));
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionReceipt(int $id)
    {
        $admissionApplication = $this->findModel($id);

        $receiptForm = new ReceiptForm();

        if ($receiptForm->load(Yii::$app->request->post()) && $receiptForm->validate()) {
            $admissionApplication = $this->admissionApplicationService->addReceipt(
                $admissionApplication,
                $receiptForm
            );

            $htmlContent = $this->renderPartial('receipt', [
                'admissionApplication' => $admissionApplication,
                'speciality'           => Speciality::findOne($admissionApplication->properties['speciality_id'])
            ]);

            $pdf = $this->pdfService->generate($htmlContent, Yii::t('app', 'Расписка')
                . " №{$admissionApplication->id}");

            return $pdf->render();
        }

        if ($receiptForm->hasErrors()) {
            Yii::$app->session->setFlash('error', current($receiptForm->firstErrors));
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Deletes an existing AdmissionApplication model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
