<?php

namespace frontend\controllers;

use common\components\Model;
use common\models\person\Person;
use common\models\person\Student;
use common\models\PersonRelative;
use common\models\link\StudentGroupLink;
use common\services\person\PersonContactService;
use common\services\person\PersonInfoService;
use common\services\person\PersonLocationService;
use common\services\person\PersonService;
use frontend\models\forms\PersonContactsForm;
use frontend\models\forms\PersonDocumentsForm;
use frontend\models\forms\StudentGeneralForm;
use frontend\search\StudentSearch;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
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
                            'view', 'view-contacts', 'view-documents', 'view-authorization', 'view-relatives',
                            'create',
                            'update', 'update-contacts', 'update-documents', 'update-relatives',
                            'delete', 'fire', 'revert', 'move', 'process',
                            'get-student-info'
                        ],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'fire'   => ['POST'],
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
        array $config = [])
    {
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
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $searchModel->status = Student::STATUS_ACTIVE;
        $searchModel->institution_id = Yii::$app->user->identity->institution->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
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
        $model = $this->findModel($id);
        return $this->render('view/view', [
            'model' => $model,
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
        $form = new PersonContactsForm($model, $this->personContactService, $this->personLocationService);

        return $this->render('view/view_contacts', [
            'model' => $this->findModel($id),
            'form'  => $form,
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
            'form'  => $form,
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
     * Displays Student documents information
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionViewRelatives($id)
    {
        $model = $this->findModel($id);

        return $this->render('view/view_relatives', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \Exception
     */
    public function actionCreate()
    {
        $form = new StudentGeneralForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model = Student::add(null, $form->firstname, $form->lastname, $form->middlename, $form->iin);
            $model->setAttributes($form->attributes);
            try {
                $model = $this->personService->create(
                    $model,
                    Yii::$app->user->identity->institution->id,
                    $form->indentity,
                    $form->credential_type,
                    Yii::$app->user->identity->activeAccessToken->token,
                    Yii::$app->user->identity->person_type
                );
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->refresh();
            }
        }

        return $this->render('create', [
            'model' => $form,
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
        $model = $this->findModel($id);
        $form = new StudentGeneralForm();
        $form->setAttributes($model->attributes);
        $form->birth_date = date('d-m-Y', strtotime($form->birth_date));
        $form->group_id = $model->group->id;
        $groups = Yii::$app->user->identity->institution->groups;

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model->setAttributes($form->attributes);
            $this->personService->update($model, Yii::$app->user->identity->institution->id);

            $student_group_link = StudentGroupLink::findOne(['student_id' => $model->id]);
            $student_group_link->group_id = $form->group_id;
            $student_group_link->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update/update', [
            'form'  => $form,
            'model' => $model,
            'groups' => $groups,
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
                            Person::TYPE_EMPLOYEE
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

    public function actionUpdateContacts($id)
    {
        $model = $this->findModel($id);
        $form = new PersonContactsForm($model, $this->personContactService, $this->personLocationService);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->apply($model, $this->personContactService, $this->personLocationService);

            return $this->redirect(['view-contacts', 'id' => $model->id]);
        }

        return $this->render('update/update_contacts', [
            'form'  => $form,
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
            'form'  => $form,
            'model' => $model,
        ]);
    }

    public function actionUpdateRelatives($id)
    {
        $model = $this->findModel($id);
        $relatives = count($model->relatives) ?  $model->relatives : [new PersonRelative()];

        if (Yii::$app->request->post()) {
            $oldIDs = ArrayHelper::map($relatives, 'id', 'id');
            $relatives = Model::createMultiple(PersonRelative::class, $relatives);
            Model::loadMultiple($relatives, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($relatives, 'id', 'id')));

            foreach($relatives as $relative) {
                $relative->person_id = $model->id;
            }

            $valid = Model::validateMultiple($relatives);

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $flag = true;
                    if (! empty($deletedIDs)) {
                        PersonRelative::deleteAll(['id' => $deletedIDs]);
                    }
                    foreach ($relatives as $relative) {
                        if (! ($flag = $relative->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view-relatives', 'id' => $model->id]);
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update/update_relatives', [
            'model'     => $model,
            'relatives' => $relatives
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
        $model = $this->findModel($id);

        $this->personService->delete($model);

        Yii::$app->session->setFlash('success', 'Пользователь успешно удален');

        return $this->redirect(['index']);
    }

    public function actionFire($id)
    {
        $model = $this->findModel($id);

        $this->personService->fire($model);

        Yii::$app->session->setFlash('success', 'Пользователь успешно отчислен');

        return $this->redirect(['index']);
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

        $this->personService->changeType($model, Person::TYPE_EMPLOYEE);

        Yii::$app->session->setFlash('success', 'Пользователь успешно перемещен');

        return $this->redirect(['index', 'status' => $status]);
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

    /**
     * @TODO Move to a service
     */
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

    public function actionGetStudentInfo($iin){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $person = Person::find()->where(['iin'=>$iin])->one();

        return $person;
    }
}
