<?php

namespace frontend\controllers;

use common\services\organization\InstitutionDisciplineService;
use common\models\organization\InstitutionDiscipline;
use common\services\person\EmployeeService;
use frontend\search\InstitutionDisciplineSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Module;

/**
 * InstitutionDisciplineController implements the CRUD actions for InstitutionDiscipline model.
 */
class InstitutionDisciplineController extends Controller
{
    private $institution;
    private $institutionDisciplineService;
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
                            'delete', 'create-ajax'
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

    public function __construct( string $id, Module $module, InstitutionDisciplineService $institutionDisciplineService, EmployeeService $employeeService, array $config = [])
    {
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

    /**
     * Lists all InstitutionDiscipline models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InstitutionDisciplineSearch();
        $searchModel->institution_id = $this->institution->id;
        //$dataProvider = new ActiveDataProvider([
          //  'query' => InstitutionDiscipline::find()->andWhere([
            //    'institution_id' => $this->institution->id /** TODO @see InstitutionDisciplineService::getInstitutionDisciplines() */
            //])
        //]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single InstitutionDiscipline model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        /*$teachers = $model->teachers;
        var_dump($model->teachers[0]);
        die();*/
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new InstitutionDiscipline model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {


        $model = new InstitutionDiscipline();

        if (Yii::$app->request->isAjax) {

            $model->load(Yii::$app->request->post());
            $model->institution_id = Yii::$app->user->identity->institution->id;
            $model->save();
            return "$model->id";
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->institution_id = Yii::$app->user->identity->institution->id;
            if ($model->save()) {
                   return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'teachers' => $this->employeeService->getTeachersActive($this->institution),
        ]);
    }

    public function actionCreateAjax()
    {
        $model = new InstitutionDiscipline();

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $model->institution_id = Yii::$app->user->identity->institution->id;
            $model->save();
        }

    }

    /**
     * Updates an existing InstitutionDiscipline model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->institution_id = Yii::$app->user->identity->institution->id;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'teachers' => $this->employeeService->getTeachersActive($this->institution),
        ]);
    }

    /**
     * Deletes an existing InstitutionDiscipline model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the InstitutionDiscipline model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InstitutionDiscipline the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /** @var InstitutionDiscipline|null $model */
        $model = InstitutionDiscipline::find()
            ->andWhere([
                'institution_id' => $this->institution->id,
                'id' => $id,
            ])
            ->one(); /** @see InstitutionDisciplineService::getInstitutionDisciplines() */

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
