<?php

namespace frontend\controllers;

use common\models\link\CommissionDisciplineLink;
use common\models\reception\Commission;
use common\services\organization\InstitutionDisciplineService;
use common\services\reception\CommissionService;
use frontend\models\forms\CommissionForm;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class CommissionController extends Controller
{
    private $institution;
    private $commissionService;
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
        array $config = []
    ) {
        $this->commissionService = $commissionService;
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

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Commission::find()->andWhere([
                'institution_id' => $this->institution->id,
            ]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCurrent()
    {
        $commission = $this->commissionService->getActiveInstitutionCommission($this->institution);
        if ($commission !== null) {
            return $this->redirect(['view', 'id' => $commission->id]);
        } else {
            return $this->render('current');
        }
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = $this->commissionService->getActiveInstitutionCommission($this->institution);
        if ($model !== null) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $form = new CommissionForm();
        $institutionDisciplines = $this->institutionDisciplineService->getInstitutionDisciplines($this->institution);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model = new Commission();
            $model->setAttributes($form->getAttributes());
            $model->institution_id = $this->institution->id;
            if ($model->save()) {
                foreach ($form->institution_discipline_ids as $institution_discipline_id) {
                    $link = new CommissionDisciplineLink();
                    $link->institution_discipline_id = $institution_discipline_id;
                    $link->commission_id = $model->id;
                    $link->save();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'form' => $form,
            'institutionDisciplines' => $institutionDisciplines
        ]);
    }

    public function actionClose($id)
    {
        $model = $this->findModel($id);

        $this->commissionService->closeCommission($model);

        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $this->commissionService->deleteCommission($model);

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord|Commission
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $model = $this->commissionService->getInstitutionCommission($this->institution, $id);
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
