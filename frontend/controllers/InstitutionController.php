<?php

namespace frontend\controllers;

use common\forms\InstitutionForm;
use common\models\organization\Institution;
use common\models\person\Employee;
use common\models\reception\Commission;
use common\services\organization\InstitutionService;
use frontend\search\InstitutionSearch;
use frontend\search\EmployeeSearch;
use frontend\models\forms\CurrentInstitutionForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

/**
 * InstitutionController implements the CRUD actions for Group model.
 */
class InstitutionController extends Controller
{
    private $institutionService;
    private $institution;

    public function __construct(string $id, $module, InstitutionService $institutionService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->institutionService = $institutionService;
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
                            'index', 'all', 'view', 'view-committee', 'view-employees', 'view-students'
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
        $institutions = Yii::$app->user->identity->institutions;
        $person = Employee::findOne(Yii::$app->user->id);
        $form = new InstitutionForm($model);
        $form2 = new CurrentInstitutionForm();
        $form2->setAttributes($person->attributes);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->institutionService->update($model, $form);
        }

        if ($form2->load(Yii::$app->request->post()) && $form2->validate()) {
            $person->current_institution = $form2->current_institution;
            if (!$person->save()) {
                if (YII_DEBUG) {
                    $errors = $person->errors;
                    throw new \RuntimeException(reset($errors)[0]);
                }
                throw new \RuntimeException('Saving error.');
            }
    
            return $this->render('index', [
                'form' => $form,
                'form2' => $form2,
                'institutions' => $institutions
            ]);
        }

        return $this->render('index', [
            'model' => $model,
            'form' => $form,
            'form2' => $form2,
            'institutions' => $institutions
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

    public function actionAll()
    {
        $searchModel = new InstitutionSearch($this->institution);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('all', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view/view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionViewCommittee($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Commission::find()
                ->andWhere([
                    Commission::tableName() . '.institution_id' => $id,
                    Commission::tableName() . '.delete_ts' => null,
                ]),
        ]);

        return $this->render('view/view-committee', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewEmployees($id)
    {
        $model = $this->findModel($id);
        $query = $model->getEmployees();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('view/view-employees', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewStudents($id)
    {
        $model = $this->findModel($id);
        $query = $model->getStudents();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('view/view-students', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

}