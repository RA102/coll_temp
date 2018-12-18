<?php

namespace frontend\controllers;

use common\models\person\Student;
use common\services\person\PersonContactService;
use common\services\person\PersonInfoService;
use frontend\models\forms\PersonContactsForm;
use frontend\models\forms\PersonDocumentsForm;
use frontend\models\forms\StudentGeneralForm;
use Yii;
use frontend\search\StudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Module;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
{
    private $personInfoService;
    private $personContactService;

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

    public function __construct(string $id, Module $module, PersonInfoService $personInfoService, PersonContactService $personContactService, array $config = [])
    {
        $this->personInfoService = $personInfoService;
        $this->personContactService = $personContactService;
        parent::__construct($id, $module, $config);
    }

    /**
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $searchModel->status = Student::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Student model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays Student contacts information
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionViewContacts($id)
    {
        $model = $this->findModel($id);
        $form = new PersonContactsForm($model, $this->personContactService);

        return $this->render('view/view_contacts', [
            'model' => $this->findModel($id),
            'form' => $form,
        ]);
    }

    /**
     * Displays Student documents information
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionViewDocuments($id)
    {
        $model = $this->findModel($id);
        $form = new PersonDocumentsForm($model, $this->personInfoService);

        return $this->render('view/view_documents', [
            'model' => $model,
            'form' => $form,
        ]);
    }

    /**
     * Displays Student authorization information
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionViewAuthorization($id)
    {
        return $this->render('view/view_authorization', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StudentGeneralForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $student = new Student();
            $student->status = 1;
            $student->setAttributes($model->attributes);
            $student->save();

            return $this->redirect(['view', 'id' => $student->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $student = $this->findModel($id);
        $model = new StudentGeneralForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $student->setAttributes($model->attributes);
            $student->save();

            return $this->redirect(['view', 'id' => $student->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'student' => $student,
        ]);
    }

    public function actionUpdateContacts($id)
    {
        $model = $this->findModel($id);
        $form = new PersonContactsForm($model, $this->personContactService);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->apply($model, $this->personContactService);

            return $this->redirect(['view-contacts', 'id' => $model->id]);
        }

        return $this->render('update/update_contacts', [
            'form' => $form,
            'model' => $model,
        ]);
    }

    public function actionUpdateDocuments($id)
    {
        $model = $this->findModel($id);
        $form = new PersonDocumentsForm($model, $this->personInfoService);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->apply($model, $this->personInfoService);

            return $this->redirect(['view-documents', 'id' => $model->id]);
        }

        return $this->render('update/update_documents', [
            'form' => $form,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Student model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionAjaxAddress($term = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];

        if (!is_null($term)) {
            $ch = curl_init(); // TODO use Guzzle instead
            $url = 'https://api.post.kz/api/byAddress/' . $term .  '?from=0';
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.1) Gecko/2008070208');
            $response = curl_exec($ch);
            curl_close($ch);

            if($response === false) {
                throw new \Exception();
            }

            $response = json_decode($response, true);

            $count = 0;
            foreach ($response['data'] as $address) {
                $count++;
                $out[] = $address['addressRus'];

                if ($count >= 10) {
                    break;
                }
            }
        }
        return $out;
    }
}
