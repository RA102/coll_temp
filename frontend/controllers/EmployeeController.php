<?php

namespace frontend\controllers;

use common\models\link\PersonInstitutionLink;
use common\models\person\Employee;
use common\models\person\Person;
use common\services\person\PersonContactService;
use common\services\person\PersonInfoService;
use common\services\person\PersonLocationService;
use common\services\person\PersonService;
use frontend\models\forms\PersonContactsForm;
use frontend\models\forms\PersonDocumentsForm;
use frontend\models\forms\StudentGeneralForm;
use frontend\search\EmployeeSearch;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
{
    private $institution;
    private $personInfoService;
    private $personContactService;
    private $personLocationService;
    private $personService;

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
                            'index',
                            'view', 'view-contacts', 'view-documents', 'view-authorization',
                            'create',
                            'update', 'update-contacts', 'update-documents',
                            'delete', 'fire', 'move', 'revert', 'process',
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
                    'fire' => ['POST'],
                    'move' => ['POST'],
                    'revert' => ['POST'],
                    'process' => ['POST'],
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
        PersonService $personService,
        array $config = []
    ) {
        $this->personInfoService = $personInfoService;
        $this->personContactService = $personContactService;
        $this->personLocationService = $personLocationService;
        $this->personService = $personService;
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
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch($this->institution);
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
     * @throws \Exception
     */
    public function actionCreate()
    {
        $form = new StudentGeneralForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model = Employee::add(null, $form->firstname, $form->lastname, $form->middlename, $form->iin);
            $model->setAttributes($form->attributes);
            $model = $this->personService->create(
                $model,
                Yii::$app->user->identity->institution->id,
                $form->indentity,
                $form->credential_type,
                Yii::$app->user->identity->activeAccessToken->token,
                Yii::$app->user->identity->person_type
            );

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
        $form->birth_date = date('d-m-Y', strtotime($form->birth_date));

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model->setAttributes($form->attributes);

            try {
                $this->personService->update($model, Yii::$app->user->identity->institution->id);
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('update/update', [
            'form' => $form,
            'model' => $model,
        ]);
    }

    public function actionProcess()
    {
        $action = \Yii::$app->request->post('action');
        $selection = \Yii::$app->request->post('selection');

        try {
            switch ($action) {
                case 'move':
                    foreach ($selection as $item) {
                        $this->personService->changeType(
                            $this->findModel(intval($item)),
                            Person::TYPE_STUDENT
                        );
                    }
                    break;
                case 'fire':
                    foreach ($selection as $item) {
                        $this->personService->fire($this->findModel(intval($item)));
                    }
                    break;
                case 'delete':
                    foreach ($selection as $item) {
                        $this->personService->delete($this->findModel(intval($item)));
                    }
                    break;
                case 'revert':
                    foreach ($selection as $item) {
                        $this->personService->revert($this->findModel(intval($item)));
                    }
                    break;
                default:
                    throw new \DomainException('No action found');
                    break;
            }

            Yii::$app->session->setFlash('success', 'Успешно сохранено');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect('index');
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
            $form->apply($model, $this->personContactService, $this->personLocationService);

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
        $model = $this->findModel($id);

        try {
            $this->personService->delete($model);
            Yii::$app->session->setFlash('success', 'Пользователь успешно удален');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionFire($id)
    {
        $model = $this->findModel($id);

        try {
            $this->personService->fire($model);
            Yii::$app->session->setFlash('success', 'Пользователь успешно уволен');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index', 'status' => Employee::STATUS_FIRED]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRevert($id)
    {
        $model = $this->findModel($id);
        $status = $model->status;
        $this->personService->revert($model);

        Yii::$app->session->setFlash('success', 'Пользователь успешно восстановлен');

        return $this->redirect(['index', 'status' => $status]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionMove($id)
    {
        $model = $this->findModel($id);
        $status = $model->status;

        $this->personService->changeType($model, Person::TYPE_STUDENT);

        Yii::$app->session->setFlash('success', 'Пользователь успешно перемещен');

        return $this->redirect(['index', 'status' => $status]);

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
            // TODO should be moved to services
            if ($model->getPersonInstitutionLinks()->andWhere([
                /** @see PersonInstitutionLink::$institution_id */
                PersonInstitutionLink::tableName() . '.institution_id' => $this->institution->id
            ])->exists()) {
                return $model;
            }
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
