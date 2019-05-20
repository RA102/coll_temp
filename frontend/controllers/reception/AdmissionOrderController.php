<?php

namespace frontend\controllers\reception;

use common\helpers\ApplicationHelper;
use common\models\reception\AdmissionApplication;
use common\services\PdfService;
use frontend\models\forms\AdmissionOrderForm;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\base\Module;

/**
 * EntranceExamOrderController
 */
class AdmissionOrderController extends Controller
{
    protected $pdfService;

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
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function __construct(
        $id,
        Module $module,
        PdfService $pdfService,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);

        $this->pdfService = $pdfService;
    }

    /**
     * @param $commission_id
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex($commission_id)
    {
        $form = new AdmissionOrderForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $applications = AdmissionApplication::find()
                ->where(['admission_application.status' => ApplicationHelper::STATUS_ENLISTED])
                ->andWhere(new Expression("properties ->> 'education_form' = '{$form->education_form}'"))
                ->andWhere(new Expression("properties ->> 'education_pay_form' = '{$form->education_pay_form}'"))
                ->andWhere(new Expression("properties ->> 'language' = '{$form->language}'"))
                ->andWhere(new Expression("properties ->> 'based_classes' = '{$form->based_classes}'"))
                ->joinWith(['student' => function(ActiveQuery $query) use ($form, $commission_id) {
                    $query->joinWith(['receptionGroup' => function (ActiveQuery $query) use ($form, $commission_id) {
                        $query->joinWith([
                            'receptionExams' => function (ActiveQuery $query) use ($form, $commission_id) {
                                return $query->andWhere(['reception.exam.commission_id' => $commission_id])
                                    ->andWhere(['reception.exam.type' => $form->exam_form]);
                            }
                        ]);
                    }]);
                }], true)
                ->all();

            $sortedApplications = [];
            foreach ($applications as $application) {
                $group = $application->student->group;
                $sortedApplications[$group->id]['group'] = $group;
                $sortedApplications[$group->id]['applications'][] = $application;
            }

            $content = $this->renderPartial('report', [
                'sortedApplications' => $sortedApplications,
                'form' => $form,
                'institution' => Yii::$app->user->identity->institution
            ]);

            $pdf = $this->pdfService->generate(
                $content,
                \Yii::t('app', 'Order of admission')
            );

            return $pdf->render();

        }

        return $this->render('index', [
            'form' => $form
        ]);
    }
}
