<?php

namespace frontend\controllers\reception;

use common\helpers\ApplicationHelper;
use common\helpers\EducationHelper;
use common\helpers\LanguageHelper;
use common\models\handbook\Speciality;
use common\models\reception\AdmissionApplication;
use common\models\reception\AdmissionProtocol;
use frontend\models\forms\EntranceExamOrderForm;
use kartik\mpdf\Pdf;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * EntranceExamOrderController
 */
class EntranceExamOrderController extends Controller
{
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

    /**
     * @param $commission_id
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex($commission_id)
    {
        $form = new EntranceExamOrderForm();
        $protocols = AdmissionProtocol::find()->where(['commission_id' => $commission_id])->all();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $successStatuses = [ApplicationHelper::STATUS_ACCEPTED, ApplicationHelper::STATUS_ENLISTED];
            $applications = AdmissionApplication::find()
                ->where(['commission_id' => $commission_id, 'status' => $successStatuses])
                ->all();

            $sortedApplications = $this->getSortedApplications($applications);

            $protocol = AdmissionProtocol::findOne($form->protocol_id);

            $content = $this->renderPartial('report', [
                'protocol' => $protocol,
                'sortedApplications' => $sortedApplications,
                'form' => $form,
                'institution' => Yii::$app->user->identity->institution
            ]);

            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'format' => Pdf::FORMAT_A4,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $content,
                'cssFile' => '@frontend/web/css/print.css',
            ]);

            return $pdf->render();
        }

        return $this->render('index', [
            'form' => $form,
            'protocols' => $protocols
        ]);
    }

    private function getSortedApplications($applications) {
        $sortedApplications = [];
        foreach ($applications as $application) {
            $uniqueKey = $application->properties['education_form'] . '|'.
                $application->properties['education_pay_form'] . '|'.
                $application->properties['based_classes'] . '|'.
                $application->properties['language'] . '|'.
                $application->properties['speciality_id'];

            $speciality = Speciality::findOne($application->properties['speciality_id']);

            $sortedApplications[$uniqueKey]['applications'][] = "{$application->properties['lastname']} {$application->properties['firstname']} {$application->properties['middlename']}";
            $sortedApplications[$uniqueKey]['education_form'] = EducationHelper::getEducationFormTypes()[$application->properties['education_form']];
            $sortedApplications[$uniqueKey]['education_pay_form'] = EducationHelper::getPaymentFormTypes()[$application->properties['education_pay_form']];
            $sortedApplications[$uniqueKey]['based_classes'] = ApplicationHelper::getBasedClassesArray()[$application->properties['based_classes']];
            $sortedApplications[$uniqueKey]['language'] = LanguageHelper::getLanguageList()[$application->properties['language']];
            $sortedApplications[$uniqueKey]['speciality'] = $speciality;
        }

        return $sortedApplications;
    }
}
