<?php

namespace frontend\controllers;

use common\models\handbook\Speciality;
use frontend\models\forms\AddSpecialityForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SpecialityController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'fire' => ['POST'],
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
            'model' => $model
        ]);
    }
}