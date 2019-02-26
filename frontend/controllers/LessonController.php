<?php

namespace frontend\controllers;

use common\models\organization\Group;
use common\models\TeacherCourse;
use common\services\person\EmployeeService;
use frontend\models\forms\LessonForm;
use frontend\search\GroupSearch;
use Yii;
use common\models\Lesson;
use frontend\search\LessonSearch;
use yii\db\ActiveQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\base\Module;

/**
 * LessonController implements the CRUD actions for Lesson model.
 */
class LessonController extends Controller
{
    private $employeeService;
    private $institution;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function __construct(
        string $id,
        Module $module,
        EmployeeService $employeeService,
        array $config = []
    ) {
        $this->employeeService = $employeeService;
        $this->institution = \Yii::$app->user->identity->institution;
        parent::__construct($id, $module, $config);
    }

    /**
     * Lists all Lesson models.
     * @param $group_id
     * @return mixed
     */
    public function actionIndex($group_id)
    {
        $group = Group::findOne($group_id); // TODO change to GroupService::getGroup

        $teacherCourses = TeacherCourse::find()->joinWith([
            /** @see TeacherCourse::getGroups() */
            'groups' => function (ActiveQuery $query) use ($group) {
                $query->andWhere(['group.id' => $group->id]);
            }
        ])->all();

        $searchModel = new LessonSearch();
        $searchModel->group_id = $group_id;

        return $this->render('index', [
            'teacherCourses' => $teacherCourses,
            'teachers' => $this->employeeService->getTeachers($this->institution),
            'searchModel' => $searchModel,
        ]);
    }

    public function actionGroups()
    {
        $searchModel = new GroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('groups', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lesson model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Lesson model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lesson();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Lesson model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Lesson model.
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
     * Finds the Lesson model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lesson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lesson::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionAjaxFeed($start, $end)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $searchModel = new LessonSearch();
        $searchModel->load(Yii::$app->request->queryParams);
        $searchModel->from_date = $start;
        $searchModel->to_date = $end;
        $dataProvider = $searchModel->search();

        $result = [];
        /** @var Lesson[] $lessons */
        $lessons = $dataProvider->getModels();
        foreach ($lessons as $lesson) {
            $result[] = LessonForm::createFromLesson($lesson);
        }

        return $result;
    }

    public function actionAjaxCreate()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $form = new LessonForm();
        $form->load(Yii::$app->request->post());

        if ($form->validate()) {
            if ($form->id) {
                $model = $this->findModel($form->id);
            } else {
                $model = new Lesson();
            }

            $form->apply($model);
            $model->save();

            return $model;
        }

        return $form;
    }

    public function actionAjaxDelete()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        $model->delete();

        return true;
    }
}
