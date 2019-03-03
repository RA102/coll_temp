<?php

namespace frontend\controllers;

use common\exceptions\TranslatableException;
use common\models\person\PersonCredential;
use common\services\organization\GroupService;
use common\services\pds\PersonCredentialService;
use frontend\models\forms\GroupAllocationForm;
use frontend\models\forms\PersonCredentialForm;
use frontend\search\StudentSearch;
use Yii;
use common\models\organization\Group;
use frontend\search\GroupSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PersonCredentialController implements the CRUD actions for PersonCredential model.
 */
class CredentialController extends Controller
{
    public $pdsPersonCredentialService;

    /**
     * CredentialController constructor.
     * @param string $id
     * @param \yii\base\Module $module
     * @param PersonCredentialService $personCredentialService
     * @param array $config
     */
    public function __construct(
        string $id,
        $module,
        PersonCredentialService $personCredentialService,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->pdsPersonCredentialService = $personCredentialService;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            // TODO: add access control
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'create' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Creates a new PersonCredential model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new PersonCredentialForm();
        $form->load(Yii::$app->request->post());

        if ($form->validate()) {
            try {
                $this->pdsPersonCredentialService->create(
                    $form->person_id,
                    $form->indentity,
                    Yii::$app->user->identity->activeAccessToken->token
                );
            } catch (TranslatableException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', Yii::t('app/error', 'Generic'));
            }
        } else {
            Yii::$app->session->setFlash('error', current($form->firstErrors));
        }

        return $this->redirect(Yii::$app->request->referrer);
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
