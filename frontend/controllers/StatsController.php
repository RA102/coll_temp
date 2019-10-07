<?php

namespace frontend\controllers;

use common\models\organization\Classroom;
use common\models\organization\Stats;
use frontend\search\ClassroomSearch;
use common\models\person\Person;
use common\models\person\Student;
use common\services\organization\GroupService;
use common\services\person\PersonService;
use frontend\models\forms\GroupAllocationForm;
use frontend\search\StudentSearch;
use Yii;
use common\models\organization\Group;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class StatsController extends Controller
{
    public $groupService;
    private $personService;

    public function __construct(string $id, $module, GroupService $groupService, PersonService $personService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->groupService = $groupService;
        $this->personService = $personService;
    }

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
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $stats = Stats::findOne($this->institution->id);

        return $this->render('index', [
            'stats' => $stats,
        ]);
    }

    /**
     * Displays a single Group model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $studentsSearch = new StudentSearch();
        $studentsSearch->formName = 'withGroup';
        $studentsSearch->institution_id = Yii::$app->user->identity->institution->id;
        $studentsSearch->group_id = $id;
        $studentsDataProvider = $studentsSearch->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'studentsSearch' => $studentsSearch,
            'studentsDataProvider' => $studentsDataProvider
        ]);
    }

    /**
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Classroom();
        $model->institution_id = Yii::$app->user->identity->institution->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $specialities = Yii::$app->user->identity->institution->specialities;

        return $this->render('update', [
            'model' => $model,
            'specialities' => $specialities,
        ]);
    }

    /**
     * Deletes an existing Group model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete_ts = date('Y-m-d H:i:s');
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Classroom::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
