<?php

namespace frontend\controllers;

use common\helpers\ReceptionExamHelper;
use common\models\organization\Institution;
use common\models\reception\Commission;
use common\models\ReceptionGroup;
use common\services\organization\InstitutionDisciplineService;
use common\services\person\EmployeeService;
use common\services\reception\CommissionService;
use common\services\ReceptionExamService;
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
    /** @var ReceptionExamService */
    private $receptionExamService;
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
        ReceptionExamService $receptionExamService,
        CommissionService $commissionService,
        InstitutionDisciplineService $institutionDisciplineService,
        EmployeeService $employeeService,
        array $config = []
    ) {
        $this->receptionExamService = $receptionExamService;
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

        $institutionDisciplines = $this->institutionDisciplineService->getInstitutionExamDisciplines($this->institution);

        $dataProvider = new ActiveDataProvider([
            'query' => ReceptionExam::find()->andWhere([
                'commission_id' => $commission->id,
            ])->with([
                'receptionGroups' /** @see ReceptionExam::getReceptionGroups() */
            ]),
        ]);

        /** @see ReceptionExam::date */
        $receptionExamsMap = [];
        /** @var ReceptionExam $receptionExam */
        foreach ($dataProvider->getModels() as $receptionExam) {
            /*if(!isset($receptionExamsMap[$receptionExam->date])) {
                $receptionExamsMap[$receptionExam->date] = [];
            }*/
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
        $institutionDiscipline = $this->findInstitutionDiscipline($this->institution, $institution_discipline_id);

        $receptionExam = new ReceptionExam();
        $receptionExam->institution_discipline_id = $institutionDiscipline->id;
        $receptionExam->date = $date;

        if ($receptionExam->load(Yii::$app->request->post())) {
            $receptionExam->commission_id = $commission->id;
            $receptionExam->grade_type = ReceptionExamHelper::examTypeToGradeTypeMap($receptionExam->type);

            $transaction = \Yii::$app->db->beginTransaction();
            if ($receptionExam->save()) {
                foreach ($receptionExam->group_ids as $group_id) {
                    $receptionGroup = ReceptionGroup::findOne($group_id);
                    /** @see ReceptionExam::getReceptionGroups() */
                    $receptionExam->link('receptionGroups', $receptionGroup);
                }
                $transaction->commit();
                return $this->redirect(['reception-exam/index', 'commission_id' => $receptionExam->commission_id]);
            }
        }

        return $this->render('create', [
            'model' => $receptionExam,
            'date' => $date,
            'institutionDisciplines' => $this->institutionDisciplineService->getInstitutionDisciplines($this->institution),
            'teachers' => $this->employeeService->getTeachers($this->institution),
            'receptionGroups' => $commission->receptionGroups,
        ]);
    }

    public function actionDelete($commission_id, $id)
    {
        $commission = $this->findCommission($this->institution, $commission_id);
        $receptionExam = $this->findCommissionExam($commission, $id);

        $transaction = \Yii::$app->db->beginTransaction();
        foreach ($receptionExam->receptionExamGrades as $receptionExamGrade) {
            $receptionExamGrade->delete();
        }
        /** @see ReceptionExam::getReceptionGroups() */
        $receptionExam->unlinkAll('receptionGroups', true);
        $receptionExam->delete();
        $transaction->commit();

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
        $model = $this->receptionExamService->get($id, $commission, null);

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
