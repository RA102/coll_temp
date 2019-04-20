<?php

namespace frontend\controllers;

use common\models\reception\Commission;
use common\services\reception\CommissionService;
use frontend\search\EmployeeSearch;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class CommissionMemberController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'create',
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

    public function actionIndex($id)
    {
        $employeeSearch = new EmployeeSearch(Yii::$app->user->identity->institution);
        $employeeSearch->commission_id = $id;
        $employeeDataProvider = $employeeSearch->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'employeeSearch' => $employeeSearch,
            'employeeDataProvider' => $employeeDataProvider
        ]);
    }
}