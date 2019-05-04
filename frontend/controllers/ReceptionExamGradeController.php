<?php

namespace frontend\controllers;

use common\models\organization\Institution;
use common\models\person\Entrant;
use common\models\ReceptionExam;
use common\models\ReceptionExamGrade;
use common\models\ReceptionGroup;
use common\services\organization\InstitutionDisciplineService;
use common\services\ReceptionExamService;
use common\services\ReceptionGroupService;
use Yii;
use yii\base\Module;
use yii\db\ActiveQuery;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ReceptionExamGradeController implements the CRUD actions for ReceptionExamGrade model.
 */
class ReceptionExamGradeController extends Controller
{
    /** @var Institution */
    private $institution;
    /** @var ReceptionGroupService */
    private $receptionGroupService;
    /** @var ReceptionExamService */
    private $receptionExamService;
    /** @var InstitutionDisciplineService */
    private $institutionDisciplineService;

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
                            'index', 'view',
                            'create', 'update',
                            'delete',
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
        ReceptionGroupService $receptionGroupService,
        ReceptionExamService $receptionExamService,
        InstitutionDisciplineService $institutionDisciplineService,
        array $config = []
    ) {
        $this->receptionGroupService = $receptionGroupService;
        $this->receptionExamService = $receptionExamService;
        $this->institutionDisciplineService = $institutionDisciplineService;
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

    public function actionIndex($reception_group_id)
    {
        $receptionGroup = $this->findReceptionGroup($this->institution, $reception_group_id);

        $receptionExams = $receptionGroup
            ->getReceptionExams()
            ->with([
                /** @see ReceptionExam::getInstitutionDiscipline() */
                'institutionDiscipline',
                /** @see ReceptionExam::getReceptionExamGrades() */
                'receptionExamGrades' => function (ActiveQuery $query) use ($receptionGroup) {
                    return $query->joinWith([
                        /** @see ReceptionExamGrade::getEntrant() */
                        'entrant' => function (ActiveQuery $query) use ($receptionGroup) {
                            /** @see Entrant::getReceptionGroups() */
                            return $query->joinWith([
                                'receptionGroup' => function (ActiveQuery $query) use ($receptionGroup) {
                                    return $query->andWhere([
                                        'link.entrant_reception_group_link.reception_group_id' => $receptionGroup->id,
                                    ]);
                                }
                            ], false);
                        }
                    ]);
                },
            ])
            ->all();

        $entrants = $receptionGroup
            ->getEntrants()
            ->all();

        $gradeMap = [];
        /** @var ReceptionExam $receptionExam */
        foreach ($receptionExams as $receptionExam) {
            foreach ($receptionExam->receptionExamGrades as $receptionExamGrade) {
                $entrant = $receptionExamGrade->entrant;
                if (!isset($gradeMap[$entrant->id])) {
                    $gradeMap[$entrant->id] = [];
                }
                $gradeMap[$entrant->id][$receptionExam->id] = $receptionExamGrade->grade;
            }
        }

        return $this->render('index', [
            'receptionGroup' => $receptionGroup,
            'entrants' => $entrants,
            'receptionExams' => $receptionExams,
            'gradeMap' => $gradeMap,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($reception_group_id, $exam_id, $entrant_id)
    {
        $receptionGroup = $this->findReceptionGroup($this->institution, $reception_group_id);
        $entrant = $receptionGroup
            ->getEntrants()
            ->andWhere([
                'id' => $entrant_id,
            ])
            ->one();
        $receptionExam = $receptionGroup
            ->getReceptionExams()
            ->andWhere([
                'id' => $exam_id,
            ])
            ->one();
        $model = ReceptionExamGrade::find()
            ->andWhere([
                'entrant_id' => $entrant->id,
                'exam_id' => $receptionExam->id,
            ])
            ->one();

        if (!$model) {
            $model = new ReceptionExamGrade();
        }

        if (!$entrant || !$receptionExam) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->exam_id = $receptionExam->id;
            $model->entrant_id = $entrant->id;

            if ($model->save()) {
                return $this->redirect(['index', 'reception_group_id' => $receptionGroup->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'receptionGroup' => $receptionGroup,
            'entrant' => $entrant,
            'receptionExam' => $receptionExam,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = ReceptionExamGrade::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    /**
     * @param Institution $institution
     * @param $id
     * @return array|ReceptionGroup
     * @throws NotFoundHttpException
     */
    protected function findReceptionGroup(Institution $institution, $id)
    {
        if (($model = $this->receptionGroupService->getInstitutionReceptionGroup($institution, $id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function findReceptionExam(Institution $institution, $id)
    {
        $receptionExam = $this->receptionExamService->get($id, null, $institution);

        if ($receptionExam !== null) {
            return $receptionExam;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
