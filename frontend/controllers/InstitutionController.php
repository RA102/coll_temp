<?php

namespace frontend\controllers;

use common\forms\InstitutionForm;
use common\models\organization\Institution;
use common\services\organization\InstitutionService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * InstitutionController implements the CRUD actions for Group model.
 */
class InstitutionController extends Controller
{
    private $institutionService;

    public function __construct(string $id, $module, InstitutionService $institutionService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->institutionService = $institutionService;
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
                        'actions' => [
                            'index'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'unlink' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = $this->findModel(Yii::$app->user->identity->institution->id);
        $form = new InstitutionForm($model);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->institutionService->update($model, $form);
            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'form' => $form
        ]);
    }

    /**
     * Finds the Institution model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Institution the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Institution::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}