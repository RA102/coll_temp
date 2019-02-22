<?php

namespace frontend\controllers;

use common\models\organization\Group;
use frontend\search\GroupSearch;
use Yii;
use common\models\Lesson;
use frontend\search\LessonSearch;
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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $dataProvider = $searchModel->search();

        $result = [];
        /** @var Lesson[] $lessons */
        $lessons = $dataProvider->getModels();
        foreach ($lessons as $lesson) {

            $start = \DateTime::createFromFormat('Y-m-d H:i:s', $lesson->date_ts);
            $end = (clone $start)->add(new \DateInterval('PT' . $lesson->duration . 'M'));

            $result[] = [
                'title' => implode(', ', array_map(function (Group $group) {
                    return $group->caption_current;
                }, $lesson->teacherCourse->groups)),
                'start' => $start->format(DATE_ATOM),
                'end' => $end->format(DATE_ATOM),
            ];
        }

        return $result;
    }
}
