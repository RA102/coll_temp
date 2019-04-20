<?php

namespace frontend\controllers;

use common\helpers\CommissionMemberHelper;
use common\models\CommissionMemberLink;
use common\models\reception\Commission;
use common\services\person\EmployeeService;
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
    private $employeeService;

    public function __construct(
        string $id,
        Module $module,
        EmployeeService $employeeService,
        array $config = []
    ) {
        $this->employeeService = $employeeService;
        parent::__construct($id, $module, $config);
    }

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

    public function actionIndex($commission_id)
    {
        $employeeSearch = new EmployeeSearch(Yii::$app->user->identity->institution);
        $employeeSearch->commission_id = $commission_id;
        $employeeDataProvider = $employeeSearch->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'employeeSearch' => $employeeSearch,
            'employeeDataProvider' => $employeeDataProvider
        ]);
    }

    public function actionCreate($id)
    {
        $roles = CommissionMemberHelper::getRoleList();
        $model = new CommissionMemberLink();
        $employees = $this->employeeService->getTeachers(Yii::$app->user->identity->institution);

        if ($model->load(Yii::$app->request->post())) {
            $model->commission_id = $id;
            if ($model->save()) {
                return $this->redirect(['index', 'id' => $id]);
            }
        }

        return $this->render('create', [
            'roles' => $roles,
            'model' => $model,
            'employees' => $employees,
        ]);
    }
}