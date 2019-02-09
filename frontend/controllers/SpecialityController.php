<?php

namespace frontend\controllers;

use common\services\organization\SpecialityService;
use frontend\models\forms\AddSpecialityForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SpecialityController extends Controller
{
    public $specialityService;

    public function __construct(
        string $id,
        $module,
        SpecialityService $specialityService,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->specialityService = $specialityService;
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
                            'index', 'unlink'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'unlink' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new AddSpecialityForm();
        $model->load(Yii::$app->request->post());

        if ($model->is_submitted) {
            echo end($model->speciality_ids);die();
        }

        return $this->render('index', [
            'model' => $model,
            'specialityInfos' => Yii::$app->user->identity->institution->specialityInfos,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUnlink($id)
    {
        $this->specialityService->unlink($id);
        return $this->redirect(['index']);
    }
}