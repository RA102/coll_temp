<?php

namespace frontend\controllers;

use common\models\organization\Group;
use common\models\TeacherCourse;
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

/**
 * LessonController implements the CRUD actions for Lesson model.
 */
class LessonController extends Controller
{
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

    /**
     * Lists all Lesson models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LessonSearch();
        $searchModel->load(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search();

        $model = new LessonForm();

        $groups = Group::find()->joinWith([

        ]);

        $teacherCourses = TeacherCourse::find()->joinWith([
            /** @see TeacherCourse::getGroups() */
            'groups' => function (ActiveQuery $query) use ($searchModel) {
                $query->andWhere(['group.id' => $searchModel->group_id]);
            }
        ])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'teacherCourses' => $teacherCourses,
        ]);
    }

    public function actionGroups()
    {
        $searchModel = new GroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $lessonSearchModel = new LessonSearch();

        return $this->render('groups', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'lessonSearchModel' => $lessonSearchModel,
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

            $start = \DateTime::createFromFormat('Y-m-d H:i:s', $lesson->date_ts);
            $end = (clone $start)->add(new \DateInterval('PT' . $lesson->duration . 'M'));

            $result[] = [
                'title' => $lesson->teacherCourse->getFullname(),
                'start' => $start->format(DATE_ATOM),
                'end' => $end->format(DATE_ATOM),
                'teacher_course_id' => $lesson->teacher_course_id,
                'groups' => array_map(function (Group $group) {
                    return $group->caption_current;
                }, $lesson->teacherCourse->groups),
                'lesson_id' => $lesson->id,
            ];
        }

        return $result;
    }

    public function actionAjaxCreate()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $form = new LessonForm();
        $form->load(Yii::$app->request->post());

        if ($form->validate()) {
            $model = new Lesson(); // TODO change to static add() method
            $model->teacher_course_id = $form->teacher_course_id;

            $start_date = \DateTime::createFromFormat('Y-m-d H:i:s', $form->start_date);
            $end_date = \DateTime::createFromFormat('Y-m-d H:i:s', $form->end_date);

            $model->date_ts = $start_date->format('Y-m-d H:i:s');
            $model->duration = ($end_date->getTimestamp() - $start_date->getTimestamp()) / 60;
            $model->save();

            return $model;
        }

        return $form;
    }
}
