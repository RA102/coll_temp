<?php

namespace backend\controllers;

use backend\models\forms\PersonCredentialForm;
use backend\models\forms\PersonForm;
use common\exceptions\ValidationException;
use common\helpers\PersonCredentialHelper;
use common\services\pds\PersonCredentialService;
use common\services\pds\PersonSearchService;
use common\services\person\PersonService;
use Yii;
use common\models\person\Person;
use backend\models\search\PersonSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PersonController implements the CRUD actions for Person model.
 */
class PersonController extends Controller
{
    private $personService;
    private $pdsPersonCredentialService;
    private $searchService;

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
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function __construct(
        string $id,
        $module,
        PersonService $personService,
        PersonCredentialService $pdsPersonCredentialService,
        PersonSearchService $searchService,
        array $config = []
    )
    {
        $this->personService = $personService;
        $this->pdsPersonCredentialService = $pdsPersonCredentialService;
        $this->searchService = $searchService;
        parent::__construct($id, $module, $config);
    }

    /**
     * Lists all Person models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Person model.
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
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \Exception
     */
    public function actionCreate()
    {
        $model = new Person();
        $form = new PersonForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model->setAttributes($form->attributes);
            try {
                $model = $this->personService->create(
                    $model,
                    $form->institution_id,
                    true,
                    $form->indentity,
                    PersonCredentialHelper::TYPE_EMAIL,
                    Yii::$app->user->identity->activeAccessToken->token,
                    Yii::$app->user->identity->person_type
                );
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error',
                    Yii::t('app', $e->getMessage() . '<hr/>' . $e->getTraceAsString()));
            }
        }

        return $this->render('create', [
            'model' => $model,
            'form' => $form
        ]);
    }

    public function actionSearch()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $field = Yii::$app->request->get('field');
        $value = Yii::$app->request->get('value');
        return $this->searchService->findOne([$field => $value]);
    }

    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new PersonForm();
        $form->setAttributes($model->getAttributes());
        $form->institution_id = $model->institution->id;
        $credentials = $model->personCredentials;
        $form->indentity = count($credentials) > 0 ? $credentials[0]->indentity : null;

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model->setAttributes($form->attributes);

            $this->personService->update($model);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'form' => $form
        ]);
    }

    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCreateCredentials($id)
    {
        $model = $this->findModel($id);
        $form = new PersonCredentialForm();
        $form->load(Yii::$app->request->post());

        if ($form->validate()) {
            try {
                $this->pdsPersonCredentialService->create(
                    $model->id,
                    $form->indentity,
                    Yii::$app->user->identity->activeAccessToken->token,
                    $model->person_type
                );
            } catch (ValidationException $e) {
                $form->addErrors($e->errors);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getTraceAsString());
            }
        }

        if ($form->hasErrors()) {
            Yii::$app->session->setFlash('error', current($form->firstErrors));
        }

        return $this->redirect(['person/update', 'id' => $model->id]);
    }

    /**
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
