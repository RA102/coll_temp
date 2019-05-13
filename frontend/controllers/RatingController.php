<?php

namespace frontend\controllers;

use common\models\ReceptionGroup;
use common\services\reception\CommissionService;
use common\services\reception\RatingService;
use kartik\mpdf\Pdf;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class RatingController extends Controller
{
    private $institution;
    private $commissionService;
    private $ratingService;

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
                            'index', 'view', 'print'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function __construct(
        string $id,
        Module $module,
        CommissionService $commissionService,
        RatingService $ratingService,
        array $config = []
    )
    {
        $this->commissionService = $commissionService;
        $this->ratingService = $ratingService;
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

    public function actionIndex2($commission_id)
    {
        $commission = $this->findCommission($commission_id);
        $dataProvider = new ActiveDataProvider([
            'query' => ReceptionGroup::find()->andWhere([
                'commission_id' => $commission->id,
            ])
        ]);

        return $this->render('index2', [
            'commission' => $commission,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView2($commission_id, $group_id)
    {

    }

    public function actionIndex($commission_id)
    {
        $commission = $this->findCommission($commission_id);

        $dataProvider = new ArrayDataProvider([
            'models' => $this->ratingService->getRatings($commission)
        ]);

        return $this->render('index', [
            'commission' => $commission,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(
        $commission_id,
        $speciality_id,
        $education_pay_form,
        $language,
        $education_form,
        $based_classes
    )
    {
        $commission = $this->findCommission($commission_id);
        $admissionApplications = $this->ratingService->getAdmissionApplicationsForRating(
            $commission,
            $speciality_id,
            $education_pay_form,
            $language,
            $education_form,
            $based_classes
        );

        return $this->render('view', [
            'commission' => $commission,
            'admissionApplications'   => $admissionApplications,
            'speciality_id' => $speciality_id,
            'education_pay_form' => $education_pay_form,
            'language' => $language,
            'education_form' => $education_form,
            'based_classes' => $based_classes,
        ]);
    }

    public function actionPrint(
        $commission_id,
        $speciality_id,
        $education_pay_form,
        $language,
        $education_form,
        $based_classes
    )
    {
        $commission = $this->findCommission($commission_id);
        $admissionApplications = $this->ratingService->getAdmissionApplicationsForRating(
            $commission,
            $speciality_id,
            $education_pay_form,
            $language,
            $education_form,
            $based_classes
        );

        $content = $this->renderPartial('print', [
            'commission' => $commission,
            'admissionApplications'   => $admissionApplications,
            'speciality_id' => $speciality_id,
            'education_pay_form' => $education_pay_form,
            'language' => $language,
            'education_form' => $education_form,
            'based_classes' => $based_classes,
        ]);

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_BLANK,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            'methods' => [
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }

    protected function findCommission($id)
    {
        $model = $this->commissionService->getInstitutionCommission($this->institution, $id);

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
