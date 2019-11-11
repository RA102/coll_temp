<?php

namespace frontend\controllers;

use common\services\organization\SpecialityService;
use frontend\models\forms\AddSpecialityForm;
use frontend\search\InstitutionSpecialityInfoSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SpecialityController extends Controller
{
    public $specialityService;

    public function __construct(
        string $id,
        $module,
        SpecialityService $specialityService,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->specialityService = $specialityService;
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
                            'index', 'unlink'
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
        $model = new AddSpecialityForm();
        $model->load(Yii::$app->request->post());

        $searchModel = new InstitutionSpecialityInfoSearch();
        $searchModel->institution_id = Yii::$app->user->identity->institution->id;
        //$searchModel->is_deleted = false;
        //$searchModel->parent_id = $parent_id > 0 ? $parent_id : null;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // add speciality
        if ($model->is_submitted) {
            $this->specialityService->link(
                end($model->speciality_ids),
                Yii::$app->user->identity->institution->id
            );
        }

        return $this->render('index', [
            'model' => $model,
            'specialityInfos' => Yii::$app->user->identity->institution->specialityInfos,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUnlink($id)
    {
        $this->specialityService->unlink($id);
        return $this->redirect(['index']);
    }
}