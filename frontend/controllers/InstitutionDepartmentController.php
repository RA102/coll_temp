<?php

namespace frontend\controllers;

use common\models\organization\InstitutionDiscipline;
use common\services\organization\InstitutionDepartmentService;
use common\models\organization\InstitutionDepartment;
use common\services\person\EmployeeService;
use frontend\search\InstitutionDepartmentSearch;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Module;

/**
 * InstitutionDepartmentController implements the CRUD actions for InstitutionDepartment model.
 */
class InstitutionDepartmentController extends Controller
{
    private $institution;
    private $institutionDepartmentService;
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
        InstitutionDepartmentService $institutionDepartmentService,
        EmployeeService $employeeService,
        array $config = []
    ) {
        $this->institutionDepartmentService = $institutionDepartmentService;
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

    /**
     * Lists all InstitutionDepartment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InstitutionDepartmentSearch();
        $searchModel->institution_id = $this->institution->id;
        //$dataProvider = new ActiveDataProvider([
        //  'query' => InstitutionDepartment::find()->andWhere([
        //    'institution_id' => $this->institution->id /** TODO @see InstitutionDepartmentService::getInstitutionDepartments() */
        //])
        //]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single InstitutionDepartment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new InstitutionDepartment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InstitutionDepartment();
        $disciplines = ArrayHelper::map(InstitutionDiscipline::find()->all(), 'id', 'caption_current');

        if(Yii::$app->request->isPost) {
            $discipline = Yii::$app->request->post('InstitutionDepartment')['disciplines'];

            if ($model->load(Yii::$app->request->post())) {
                $model->institution_id = Yii::$app->user->identity->institution->id;
                if ($model->save()) {
                    if ($model->saveDisciplines($discipline)) {
                        return $this->redirect(['index', 'id' => $model->id]);
                    }
                    return $this->redirect(['index', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'disciplines' => $disciplines
        ]);
    }

    /**
     * Updates an existing InstitutionDepartment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $disciplines = ArrayHelper::map(InstitutionDiscipline::find()->all(), 'id', 'caption_current');
        if(Yii::$app->request->isPost)
        {
            $discipline = Yii::$app->request->post('InstitutionDepartment')['disciplines'];
            if ($model->saveDisciplines($discipline)) {
                return $this->redirect(['index', 'id' => $model->id]);
            }
            if ($model->load(Yii::$app->request->post())) {
                $model->institution_id = Yii::$app->user->identity->institution->id;
                if ($model->save()) {
                    return $this->redirect(['index', 'id' => $model->id]);
                }
            }
        }


        return $this->render('update', [
            'model' => $model,
            'disciplines' => $disciplines
        ]);


    }

    /**
     * Deletes an existing InstitutionDepartment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id);
        $model = InstitutionDepartment::findOne($id);
        $model->delete_ts = date('d.m.Y H:i:s');
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the InstitutionDepartment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InstitutionDepartment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /** @var InstitutionDepartment|null $model */
        $model = InstitutionDepartment::find()
            ->andWhere([
                'institution_id' => $this->institution->id,
                'id' => $id,
            ])
            ->one(); /** @see InstitutionDepartmentService::getInstitutionDepartments() */

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
