<?php

namespace frontend\controllers;

use common\models\reception\AdmissionApplication;
use common\services\reception\CommissionService;
use frontend\models\forms\JournalForm;
use kartik\mpdf\Pdf;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class AccountabilityController extends Controller
{
    private $institution;
    private $commissionService;

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
                            'journal'
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
        array $config = []
    ) {
        $this->commissionService = $commissionService;
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

    public function actionJournal()
    {
        $form = new JournalForm();
        $query = AdmissionApplication::find()->andWhere([
            'institution_id' => $this->institution->id,
//            'status' => ApplicationHelper::STATUS_ACCEPTED,
        ])->with([
            /** @see AdmissionApplication::getPerson() */
            'person'
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($form->load(\Yii::$app->request->queryParams) && $form->validate()) {
            if ($form->education_form) {
                $query->andWhere(new Expression("properties @> '{\"education_form\": \"{$form->education_form}\"}'"));
            }
            if ($form->education_pay_form) {
                $query->andWhere(new Expression("properties @> '{\"education_pay_form\": \"{$form->education_pay_form}\"}'"));
            }
            if ($form->language) {
                $query->andWhere(new Expression("properties @> '{\"language\": \"{$form->language}\"}'"));
            }

            if ($form->export) {
                $specialitiesMap = [];
                foreach ($this->institution->specialities as $speciality) {
                    $specialitiesMap[$speciality->id] = $speciality;
                }
                $content = $this->renderPartial('_journal', [
                    'dataProvider' => $dataProvider,
                    'form' => $form,
                    'specialities' => $specialitiesMap,
                ]);

                $pdf = new Pdf([
                    // set to use core fonts only
                    'mode' => Pdf::MODE_BLANK,
                    // A4 paper format
                    'format' => Pdf::FORMAT_A4,
                    // portrait orientation
                    'orientation' => Pdf::ORIENT_LANDSCAPE,
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
        }

        return $this->render('journal', [
            'dataProvider' => $dataProvider,
            'form' => $form,
            'specialities' => $this->institution->specialities,
        ]);
    }
}
