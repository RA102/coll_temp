<?php

namespace frontend\controllers;

use common\models\organization\Institution;
use common\models\organization\InstitutionDiscipline;
use common\models\reception\Commission;
use common\services\organization\InstitutionDisciplineService;
use common\services\person\EmployeeService;
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
    /** @var Institution */
    private $institution;
    /** @var CommissionService */
    private $commissionService;
    /** @var InstitutionDisciplineService */
    private $institutionDisciplineService;
    /** @var EmployeeService */
    private $employeeService;

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
        InstitutionDisciplineService $institutionDisciplineService,
        EmployeeService $employeeService,
        array $config = []
    ) {
        $this->commissionService = $commissionService;
        $this->institutionDisciplineService = $institutionDisciplineService;
        $this->employeeService = $employeeService;
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

        $institutionDisciplines = InstitutionDiscipline::find()->andWhere(
            InstitutionDiscipline::TYPE_EXAM . " = ANY(\"types\")"
        )->all();

        $dataProvider = new ActiveDataProvider([
            'query' => ReceptionExam::find()->andWhere([
                'commission_id' => $commission->id,
            ]),
        ]);

        /** @see ReceptionExam::date */
        $receptionExamsMap = [];
        /** @var ReceptionExam $receptionExam */
        foreach ($dataProvider->getModels() as $receptionExam) {
            if(!isset($receptionExamsMap[$receptionExam->date])) {
                $receptionExamsMap[$receptionExam->date] = [];
            }
            $receptionExamsMap[$receptionExam->date][] = $receptionExam;
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'receptionExamsMap' => $receptionExamsMap,
            'commission' => $commission,
            'institutionDisciplines' => $institutionDisciplines,
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

    public function actionCreate($commission_id, $date, $institution_discipline_id)
    {
        $commission = $this->findCommission($this->institution, $commission_id);
        $receptionExam = new ReceptionExam();
        $receptionExam->institution_discipline_id = $institution_discipline_id;
        $receptionExam->date = $date;

        if ($receptionExam->load(Yii::$app->request->post())) {
            $receptionExam->commission_id = $commission->id;

            if ($receptionExam->save()) {
                return $this->redirect(['reception-exam/index', 'commission_id' => $receptionExam->commission_id]);
            }
        }

        return $this->render('create', [
            'model' => $receptionExam,
            'date' => $date,
            'institutionDisciplines' => $this->institutionDisciplineService->getInstitutionDisciplines($this->institution),
            'teachers' => $this->employeeService->getTeachers($this->institution),
        ]);
    }

    public function actionUpdate($commission_id, $id)
    {
        $commission = $this->findCommission($this->institution, $commission_id);
        $receptionExam = $this->findCommissionExam($commission, $id);

        if ($receptionExam->load(Yii::$app->request->post())) {
            $receptionExam->commission_id = $commission->id;

            if ($receptionExam->save()) {
                return $this->redirect(['reception-exam/index', 'commission_id' => $receptionExam->commission_id]);
            }
        }

        return $this->render('update', [
            'model' => $receptionExam,
            'institutionDiscipline' => $receptionExam->institutionDiscipline,
            'teachers' => $this->employeeService->getTeachers($this->institution),
        ]);
    }

    public function actionDelete($commission_id, $id)
    {
        $commission = $this->findCommission($this->institution, $commission_id);
        $receptionExam = $this->findCommissionExam($commission, $id);

        $receptionExam->delete();

        return $this->redirect(['reception-exam/index', 'commission_id' => $receptionExam->commission_id]);
    }

    /**
     * @param Commission $commission
     * @param $id
     * @return array|null|\yii\db\ActiveRecord|ReceptionExam
     * @throws NotFoundHttpException
     */
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

    protected function findInstitutionDiscipline(Institution $institution, $id)
    {
        $model = $this->institutionDisciplineService->getInstitutionDiscipline($institution, $id);
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
