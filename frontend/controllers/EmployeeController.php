<?php

namespace frontend\controllers;

use common\models\person\Employee;
use common\services\person\PersonContactService;
use common\services\person\PersonInfoService;
use common\services\person\PersonLocationService;
use frontend\models\forms\PersonContactsForm;
use frontend\models\forms\PersonDocumentsForm;
use frontend\models\forms\StudentGeneralForm;
use frontend\search\EmployeeSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Module;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
{
    private $personInfoService;
    private $personContactService;
    private $personLocationService;

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
        PersonInfoService $personInfoService,
        PersonContactService $personContactService,
        PersonLocationService $personLocationService,
        array $config = []
    ) {
        $this->personInfoService = $personInfoService;
        $this->personContactService = $personContactService;
        $this->personLocationService = $personLocationService;
        parent::__construct($id, $module, $config);
    }

    /**
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $searchModel->status = Employee::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employee model.
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
     * Displays Employee contacts information
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionViewContacts($id)
    {
        $model = $this->findModel($id);
        $form = new PersonContactsForm($model, $this->personContactService, $this->personLocationService);

        return $this->render('view/view_contacts', [
            'model' => $this->findModel($id),
            'form' => $form,
        ]);
    }

    /**
     * Displays Employee documents information
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
     * Displays Employee authorization information
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
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new StudentGeneralForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model = Employee::add(null, $form->firstname, $form->lastname, $form->middlename, $form->iin);
            $model->setAttributes($form->attributes);
            $model->save();

            return $this->redirect(['update-contacts', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing EmployeeEmployee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new StudentGeneralForm();
        $form->setAttributes($model->attributes);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model->setAttributes($form->attributes);
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update/update', [
            'form' => $form,
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateContacts($id)
    {
        $model = $this->findModel($id);
        $form = new PersonContactsForm($model, $this->personContactService, $this->personLocationService);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->apply($model, $this->personContactService);

            return $this->redirect(['view-contacts', 'id' => $model->id]);
        }

        return $this->render('update/update_contacts', [
            'form' => $form,
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
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
     * Deletes an existing Employee model.
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
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
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
