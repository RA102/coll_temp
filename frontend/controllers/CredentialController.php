<?php

namespace frontend\controllers;

use common\exceptions\ValidationException;
use common\models\person\PersonCredential;
use common\services\pds\PersonCredentialService;
use frontend\models\forms\PersonCredentialForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

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
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
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
                    Yii::$app->user->identity->activeAccessToken->token,
                    Yii::$app->user->identity->person_type
                );
            } catch (ValidationException $e) {
                $form->addErrors($e->errors);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', Yii::t('app/error', 'Generic'));
            }
        }

        if ($form->hasErrors()) {
            Yii::$app->session->setFlash('error', current($form->firstErrors));
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDelete($id)
    {
        $pc = PersonCredential::findOne($id);
        $pc->delete_ts = date('Y-m-d H:i:s');
        $pc->save();

        return $this->redirect(Yii::$app->request->referrer);
    }    
}
