<?php

namespace frontend\controllers\reception;

use common\models\reception\AdmissionProtocol;
use common\services\person\EntrantService;
use frontend\models\forms\EntranceExamOrderForm;
use Yii;
use common\models\reception\AppealApplication;
use frontend\search\AppealApplicationSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Module;

/**
 * AppealApplicationController implements the CRUD actions for AppealApplication model.
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

        }

        return $this->render('index', [
            'form' => $form,
            'protocols' => $protocols
        ]);
    }
}
