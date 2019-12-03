<?php

namespace frontend\controllers;

use common\models\person\Person;
use common\models\person\Student;
use common\models\link\StudentGroupLink;
use common\services\organization\GroupService;
use common\services\person\PersonService;
use frontend\models\forms\GroupAllocationForm;
use frontend\search\StudentSearch;
use Yii;
use common\models\organization\Group;
use frontend\search\GroupSearch;
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
class GroupController extends Controller
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
        $searchModel = new GroupSearch();
        $searchModel->institution_id = Yii::$app->user->identity->institution->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $model = new Group();
        $model->institution_id = Yii::$app->user->identity->institution->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $specialities = Yii::$app->user->identity->institution->specialities;

        return $this->render('create', [
            'model' => $model,
            'specialities' => $specialities,
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

        $student_group_links = StudentGroupLink::find()->where(['group_id' => $model->id])->all();
        foreach ($student_group_links as $link) {
            $link->delete();
        }

        $model->save();
        
        $student_group_links = StudentGroupLink::find()->where(['group_id' => $model->id])->all();
        foreach ($student_group_links as $link) {
            $link->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Allocate students into groups
     * @return string
     */
    public function actionAllocate()
    {
        $allocationModel = new GroupAllocationForm();
        $years = Yii::$app->user->identity->institution->getYearList();

        $allocationModel->load(Yii::$app->request->get());

        $groups = [];
        if ($allocationModel->class) {
            $groups = $this->groupService->getByClass($allocationModel->class, Yii::$app->user->identity->institution->id);
        }

        // students from selected group
        $fromCurrentGroupSearch = new StudentSearch();
        $fromCurrentGroupSearch->formName = 'withGroup';
        $fromCurrentGroupSearch->institution_id = Yii::$app->user->identity->institution->id;
        $studentsFromGroupDataProvider = new ActiveDataProvider();

        // not allocated students (without groups)
        $withoutGroupSearch = new StudentSearch();
        $withoutGroupSearch->formName = 'withoutGroup';
        $withoutGroupSearch->status = Person::STATUS_ACTIVE;
        $withoutGroupSearch->institution_id = Yii::$app->user->identity->institution->id;
        $studentsWithoutGroupDataProvider = new ActiveDataProvider();

        if ($allocationModel->group_id) {
            $fromCurrentGroupSearch->group_id = $allocationModel->group_id;
            $studentsFromGroupDataProvider = $fromCurrentGroupSearch->search(Yii::$app->request->queryParams);

            $withoutGroupSearch->withoutGroup = true;
            $studentsWithoutGroupDataProvider = $withoutGroupSearch->search(Yii::$app->request->queryParams);
        }

        Url::remember();

        return $this->render('allocate', [
            'allocationModel' => $allocationModel,
            'years' => $years,
            'groups' => $groups,
            'withoutGroupSearch' => $withoutGroupSearch,
            'fromCurrentGroupSearch' => $fromCurrentGroupSearch,
            'studentsWithoutGroupDataProvider' => $studentsWithoutGroupDataProvider,
            'studentsFromGroupDataProvider' => $studentsFromGroupDataProvider
        ]);
    }

    /**
     * Add student to group
     * @param $id
     * @param $group_id
     * @param $class
     * @return \yii\web\Response
     */
    public function actionAddStudent($id, $group_id, $class)
    {
        $this->groupService->addStudent($id, $group_id);
        return $this->redirect(['group/allocate', 'class' => $class, 'group_id' => $group_id]);
    }

    /**
     * Delete student from group
     * @param $id
     * @param $group_id
     * @param $class
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteStudent($id, $group_id, $class)
    {
        $this->groupService->deleteStudent($id, $group_id);
        return $this->redirect(['group/allocate', 'class' => $class, 'group_id' => $group_id]);
    }

    /**
     * Sometimes deleting students from institution in group allocation is needed
     * @param $id
     * @param $group_id
     * @param $class
     * @return \yii\web\Response
     */
    public function actionDeleteStudentFromInstitution($id, $group_id, $class) {
        $model = Student::findOne($id);
        $this->personService->delete($model);

        return $this->redirect(['group/allocate', 'class' => $class, 'group_id' => $group_id]);
    }

    /**
     * List of groups by year(class or course) for dependent dropdown
     * @return string
     */
    public function actionByYear()
    {
        $parents = Yii::$app->request->post('depdrop_parents');

        if ($parents != null) {
            $class = $parents[0];

            return Json::encode([
                'output' => $this->groupService->getAssociativeByClass($class, Yii::$app->user->identity->institution->id),
                'selected' => ''
            ]);
        }

        return Json::encode(['output' => '', 'selected' => '']);
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
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
