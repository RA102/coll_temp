<?php

namespace frontend\controllers;

use common\models\organization\Institution;
use common\models\reception\Commission;
use common\services\reception\CommissionService;
use Yii;
use common\models\ReceptionExam;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReceptionExamController implements the CRUD actions for ReceptionExam model.
 */
class ReceptionExamController extends Controller
{
    private $institution;
    private $commissionService;

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
                            'index', 'view', 'current',
                            'create',
                            'close', 'delete',
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

    public function __construct(
        string $id,
        Module $module,
        CommissionService $commissionService,
        array $config = []
    ) {
        $this->commissionService = $commissionService;
        parent::__construct($id, $module, $config);
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $this->institution = \Yii::$app->user->identity->institution;
        return true;
    }

    public function actionIndex($commission_id)
    {
        $commission = $this->findCommission($this->institution, $commission_id);

        $dataProvider = new ActiveDataProvider([
            'query' => ReceptionExam::find()->andWhere([
                'commission_id' => $commission->id,
            ]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($commission_id, $id)
    {
        $commission = $this->findCommission($this->institution, $commission_id);
        $receptionExam = $this->findCommissionExam($commission, $id);

        return $this->render('view', [
            'model' => $receptionExam,
        ]);
    }

    public function actionCreate($commission_id)
    {
        $commission = $this->findCommission($this->institution, $commission_id);
        $receptionExam = new ReceptionExam();

        if ($receptionExam->load(Yii::$app->request->post())) {
            $receptionExam->commission_id = $commission->id;
            if ($receptionExam->save()) {
                return $this->redirect(['view', 'id' => $receptionExam->id]);
            }
        }

        return $this->render('create', [
            'model' => $receptionExam,
        ]);
    }

    public function actionUpdate($commission_id, $id)
    {
        $commission = $this->findCommission($this->institution, $commission_id);
        $receptionExam = $this->findCommissionExam($commission, $id);

        if ($receptionExam->load(Yii::$app->request->post())) {
            if ($receptionExam->save()) {
                return $this->redirect(['view', 'id' => $receptionExam->id]);
            }
        }

        return $this->render('update', [
            'model' => $receptionExam,
        ]);
    }

    public function actionDelete($commission_id, $id)
    {
        $commission = $this->findCommission($this->institution, $commission_id);
        $receptionExam = $this->findCommissionExam($commission, $id);

        $receptionExam->delete();

        return $this->redirect(['index']);
    }

    protected function findCommissionExam(Commission $commission, $id)
    {
        $model = ReceptionExam::find()->andWhere([
            'commission_id' => $commission->id,
            'id' => $id,
        ])->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function findCommission(Institution $institution, $id)
    {
        $model = $this->commissionService->getInstitutionCommission($institution, $id);
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
