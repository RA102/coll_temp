<?php

namespace frontend\controllers;

use common\helpers\CommissionMemberHelper;
use common\models\link\AppealCommissionMemberLink;
use common\models\link\CommissionMemberLink;
use common\services\person\EmployeeService;
use frontend\search\AppealCommissionMemberSearch;
use frontend\search\CommissionMemberLinkSearch;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class AppealCommissionMemberController extends Controller
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
                            'delete'
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
        $search = new AppealCommissionMemberSearch();
        $search->appeal_commission_id = $commission_id;
        $dataProvider = $search->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'search' => $search,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate($id)
    {
        $roles = CommissionMemberHelper::getRoleList();
        $model = new AppealCommissionMemberLink();
        $model->appeal_commission_id = $id;
        $employees = $this->employeeService->getTeachers(Yii::$app->user->identity->institution);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['index', 'commission_id' => $id]);
            } else {
                var_dump($model->getErrors());
            }
        }

        return $this->render('create', [
            'roles' => $roles,
            'model' => $model,
            'employees' => $employees,
        ]);
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the CommissionMemberLink model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppealCommissionMemberLink the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AppealCommissionMemberLink::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}