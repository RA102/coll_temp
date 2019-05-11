<?php

namespace frontend\controllers\reception;

use common\helpers\ApplicationHelper;
use common\helpers\EducationHelper;
use common\helpers\LanguageHelper;
use common\models\handbook\Speciality;
use common\models\reception\AdmissionApplication;
use common\models\reception\AdmissionProtocol;
use frontend\models\forms\AdmissionOrderForm;
use frontend\models\forms\EntranceExamOrderForm;
use kartik\mpdf\Pdf;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * EntranceExamOrderController
 */
class AdmissionOrderController extends Controller
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
        $form = new AdmissionOrderForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            // find enlisted admission applications
        }

        return $this->render('index', [
            'form' => $form
        ]);
    }
}
