<?php

namespace frontend\controllers\reception;

use common\helpers\ApplicationHelper;
use common\models\reception\AdmissionApplication;
use common\models\reception\AdmissionProtocol;
use frontend\models\forms\EntranceExamOrderForm;
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
        }

        return $this->render('index', [
            'form' => $form,
            'protocols' => $protocols
        ]);
    }
}
