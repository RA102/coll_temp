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
use common\helpers\EducationHelper;
use common\models\gosp\MessageStatusBody;
use common\models\person\Person;
use common\models\reception\AdmissionFiles;
use common\services\gosp\GospService;
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
    public $gospService;

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
        GospService $gospService,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);

        $this->admissionApplicationService = $admissionApplicationService;
        $this->commissionService = $commissionService;
        $this->pdfService = $pdfService;
        $this->gospService = $gospService;
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

        //$aa_files = AdmissionFiles::find()->where(['aa_id' => $id])->all(); //->limit(20)->all();

        return $this->render('view/view', [
            'model'       => $model,
            'receiptForm' => $receiptForm,
            //'aa_files' => $aa_files
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
        $institution = Yii::$app->user->identity->institution;

        if ($admissionApplicationForm->load(Yii::$app->request->post()) && $admissionApplicationForm->validate()) {

            $commission = $this->commissionService->getActiveInstitutionCommission(
                $institution
            );
            if (!$commission) {
                Yii::$app->session->setFlash('error',
                    Yii::t('app', 'Необходимо создать текущую комиссию для приема завлений'));
            }

            $admissionApplication = $this->admissionApplicationService->create(
                $admissionApplicationForm,
                $commission->id,
                $institution->id, 
                0
                
            );

            return $this->redirect(['view', 'id' => $admissionApplication->id]);
        }

        return $this->render('create', [
            'admissionApplicationForm' => $admissionApplicationForm,
            'specialities'             => $institution->specialities
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
            $user = Yii::$app->user->identity; 
            //if ($admissionApplication->status != $changeStatusForm->status) {
                $this->admissionApplicationService->changeStatus(
                    $id,
                    $changeStatusForm->status,
                    $user,
                    $changeStatusForm->reception_group_id,
                    $changeStatusForm->reason
                );
            //}
            if ($admissionApplication->online > 0){
                //отправляем оповещение
                $msb = new MessageStatusBody();

                $msb->Child_iin = $admissionApplication->properties['iin'];
                $msb->child_name = $admissionApplication->properties['firstname'];
                $msb->child_surname = $admissionApplication->properties['lastname'];
                $msb->child_middlename = $admissionApplication->properties['middlename'];
                
                $msb->messageId = $admissionApplication->online_msg_id;     //, "messageId": "171469959"
                $msb->messageDate = date('c');                              // 2019-03-16T17:55:09+03:00 //"messageDate": "2020-06-11T17:22:05.428+06:00"
                $msb->messageType = "NOTIFICATION";                         // "messageType": "RESPONSE"
                //$body->answer_type_doc = "";     //, "answer_type_doc": 3
                
                $msb->user_name = "SECRET";             // $user->firstname;   //, "user_name": "МАДИНА"
                $msb->user_surname = "USER";            //$user->lastname; 
        
                $msb->resolutionDate = date('c');


                $status = $changeStatusForm->status;
                $sendresp = $this->gospService->sendNotification($msb, $status);

                if ($changeStatusForm->status == ApplicationHelper::STATUS_ACCEPTED){
                    $msb->messageType = "RESPONSE";
                    $msb->resolutionType = "POSITIVE";
                    $cur_edu_form = $admissionApplication->properties['education_form'];
                    // const EDUCATION_FORM_FULL_TIME = 1; //очное
                    // const EDUCATION_FORM_EXTRAMURAL = 2; // заочное
                    // const EDUCATION_FORM_EVENING = 3; // вечернее
                    $str_edu_form = "0";
                    if ($cur_edu_form == EducationHelper::EDUCATION_FORM_FULL_TIME){
                        $str_edu_form = "0";                        
                    }
                    $msb->study_form = $str_edu_form;                   //0-очная

                    $msb->orderNo_tipo = strval($admissionApplication->id);
                    $msb->date_orderNo_tipo = date('c'); //текущая
                    $msb->Output_Type_doc = "1";              //1 - Уведомление о приеме документов в ТиПО
                    $spec = Speciality::findOne($admissionApplication->properties['speciality_id']);
                    $msb->postSecondary_spec_code = $spec->code;       //1001022
                    $msb->postSecondary_spec_nameru = $spec->caption_ru;     //100102 2 - Шөміш
                    $msb->postSecondary_spec_namekz = $spec->caption_kk;     //2 - Ковшевой
                    
                    //send COMPLITED
                    $sendresp =$this->gospService->sendResponse($msb, $status);
                    
                }

                if ($changeStatusForm->status == ApplicationHelper::STATUS_DECLINED){
                    $msb->messageType = "RESPONSE";
                    $msb->resolutionType = "NEGATIVE";
                    
                    $cur_edu_form = $admissionApplication->properties['education_form'];
                    // const EDUCATION_FORM_FULL_TIME = 1; //очное
                    // const EDUCATION_FORM_EXTRAMURAL = 2; // заочное
                    // const EDUCATION_FORM_EVENING = 3; // вечернее
                    $str_edu_form = "0";
                    if ($cur_edu_form == EducationHelper::EDUCATION_FORM_FULL_TIME){
                        $str_edu_form = "0";                        
                    }
                    $msb->study_form = $str_edu_form;                   //0-очная

                    $msb->orderNo_tipo = strval($admissionApplication->id);
                    $msb->date_orderNo_tipo = date('c'); //текущая
                    $msb->Output_Type_doc = "2";              //2 - Отрицательно
                    $spec = Speciality::findOne($admissionApplication->properties['speciality_id']);
                    $msb->postSecondary_spec_code = $spec->code;       //1001022
                    $msb->postSecondary_spec_nameru = $spec->caption_ru;     //100102 2 - Шөміш
                    $msb->postSecondary_spec_namekz = $spec->caption_kk;     //2 - Ковшевой
                    
                    $msb->negativeResolutionReasonTextRu = $changeStatusForm->reason;
                    $msb->negativeResolutionReasonTextKk = $changeStatusForm->reason;
                    //send COMPLITED
                    $sendresp =$this->gospService->sendResponse($msb, $status);
                    
                }


            }


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
