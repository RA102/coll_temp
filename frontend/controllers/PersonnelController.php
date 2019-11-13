<?php

namespace frontend\controllers;

use common\models\Facultative;
use common\models\RequiredDisciplines;
use common\models\OptionalDisciplines;
use common\models\Practice;
use common\models\PracticePlan;
use common\models\Exams;
use common\models\Ktp;
use common\models\TeacherCourse;
use common\models\organization\Group;
use common\models\organization\Institution;
use common\models\organization\InstitutionDiscipline;
use common\models\person\Employee;
use common\models\person\Student;
use common\services\organization\InstitutionDisciplineService;
use common\services\person\EmployeeService;
use frontend\search\GroupSearch;
use frontend\search\EmployeeSearch;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
class PersonnelController extends Controller
{
    private $institution;
    private $institutionDisciplineService;
    private $employeeService;

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
        InstitutionDisciplineService $institutionDisciplineService,
        EmployeeService $employeeService,
        array $config = []
    ) {
        $this->institutionDisciplineService = $institutionDisciplineService;
        $this->employeeService = $employeeService;
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
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }

    public function actionRequiredGroup()
    {
        $searchModel = new GroupSearch();
        $searchModel->institution_id = Yii::$app->user->identity->institution->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('required/group', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRequiredGroupView($group_id)
    {
        $group = Group::findOne($group_id);
    	$required = RequiredDisciplines::find()
                ->where(['group_id' => $group_id])
                ->joinWith('institutionDiscipline')
                ->andWhere([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id])
                ->all();

        return $this->render('required/group-view', [
            'group' => $group,
        	'required' => $required,
        ]);
    }

    public function actionRequiredDiscipline()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => InstitutionDiscipline::find()->andWhere([
                'institution_id' => $this->institution->id /** TODO @see InstitutionDisciplineService::getInstitutionDisciplines() */
            ])
        ]);

        return $this->render('required/discipline', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRequiredDisciplineView($discipline_id)
    {
        $discipline = InstitutionDiscipline::findOne($discipline_id);
    	$required = RequiredDisciplines::find()
                ->where([RequiredDisciplines::tableName().'.discipline_id' => $discipline_id])
                ->joinWith('institutionDiscipline')
                ->andWhere([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id])
                ->all();

        return $this->render('required/discipline-view', [
            'discipline' => $discipline,
        	'required' => $required,
        ]);
    }

    public function actionRequiredTeacher()
    {
		$searchModel = new EmployeeSearch($this->institution);
        $searchModel->status = Employee::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('required/teacher', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);    }

    public function actionRequiredTeacherView($teacher_id)
    {
        $teacher = Employee::findOne($teacher_id);

    	$required = RequiredDisciplines::find()
                ->joinWith('teacherCourse')
                ->andWhere([TeacherCourse::tableName().'.teacher_id' => $teacher_id])
                ->joinWith('institutionDiscipline')
                ->andWhere([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id])
                ->all();

        return $this->render('required/teacher-view', [
            'teacher' => $teacher,
        	'required' => $required,
        ]);
    }

    public function actionOptionalDiscipline()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => InstitutionDiscipline::find()
                    ->andWhere([
                        'institution_id' => $this->institution->id, /** TODO @see InstitutionDisciplineService::getInstitutionDisciplines() */
                    ])
        ]);

        return $this->render('optional/discipline', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOptionalDisciplineView($discipline_id)
    {
        $discipline = InstitutionDiscipline::findOne($discipline_id);
        $data = OptionalDisciplines::find()
                ->where([OptionalDisciplines::tableName().'.discipline_id' => $discipline_id])
                ->joinWith('institutionDiscipline')
                ->andWhere([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id])
                ->all();

        return $this->render('optional/discipline-view', [
            'discipline' => $discipline,
            'data' => $data,
        ]);
    }

    public function actionOptionalTeacher()
    {
        $searchModel = new EmployeeSearch($this->institution);
        $searchModel->status = Employee::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('optional/teacher', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);    }

    public function actionOptionalTeacherView($teacher_id)
    {
        $teacher = Employee::findOne($teacher_id);

        $data = OptionalDisciplines::find()
                ->where(['teacher_id' => $teacher_id])
                ->joinWith('institutionDiscipline')
                ->andWhere([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id])
                ->all();

        return $this->render('optional/teacher-view', [
            'teacher' => $teacher,
            'data' => $data,
        ]);
    }

    public function actionFacultativeGroup()
    {
        $searchModel = new GroupSearch();
        $searchModel->institution_id = Yii::$app->user->identity->institution->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('facultative/group', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFacultativeGroupView($group_id)
    {
        $group = Group::findOne($group_id);

        $facultative = Facultative::find()
                ->where(['group_id' => $group_id])
                ->all();

        return $this->render('facultative/group-view', [
            'group' => $group,
            'facultative' => $facultative,
        ]);
    }

    public function actionFacultativeDiscipline()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TeacherCourse::find()->andWhere([
                'status' => TeacherCourse::FACULTATIVE,
            ])
        ]);

        return $this->render('facultative/facultative', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFacultativeDisciplineView($teacher_course_id)
    {
        $teacherCourse = TeacherCourse::findOne($teacher_course_id);

        $facultatives = Facultative::find()
                ->where([Facultative::tableName().'.teacher_course_id' => $teacher_course_id])
                ->all();

        return $this->render('facultative/facultative-view', [
            'teacherCourse' => $teacherCourse,
            'facultatives' => $facultatives,
        ]);
    }

    public function actionFacultativeTeacher()
    {
        $searchModel = new EmployeeSearch($this->institution);
        $searchModel->status = Employee::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('facultative/teacher', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);    }

    public function actionFacultativeTeacherView($teacher_id)
    {
        $teacher = Employee::findOne($teacher_id);

        $facultatives = Facultative::find()
                ->where([Facultative::tableName().'.teacher_id' => $teacher_id])
                ->all();

        return $this->render('facultative/teacher-view', [
            'teacher' => $teacher,
            'facultatives' => $facultatives,
        ]);
    }

    public function actionPracticeGroup()
    {
        $searchModel = new GroupSearch();
        $searchModel->institution_id = Yii::$app->user->identity->institution->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('practice/group', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPracticeGroupView($group_id)
    {
        $group = Group::findOne($group_id);
        $data = PracticePlan::find()
                ->where(['group_id' => $group_id])
                ->all();

        return $this->render('practice/group-view', [
            'group' => $group,
            'data' => $data,
        ]);
    }

    public function actionPracticeDiscipline()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Practice::find()
                        ->where([Practice::tableName().'.institution_id' => $this->institution->id])
        ]);

        return $this->render('practice/practice', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPracticeDisciplineView($id)
    {
        $practice = Practice::findOne($id);
        $data = PracticePlan::find()
                ->where(['practice_id' => $id])
                ->all();

        return $this->render('practice/practice-view', [
            'practice' => $practice,
            'data' => $data,
        ]);
    }

    public function actionPracticeTeacher()
    {
        $searchModel = new EmployeeSearch($this->institution);
        $searchModel->status = Employee::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('practice/teacher', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);    
    }

    public function actionPracticeTeacherView($teacher_id)
    {
        //$data = PracticePlan::find()
          //      ->where([PracticePlan::tableName().'.teacher' => $teacher_id])
            //    ->all();
        $sql = "SELECT * FROM ".PracticePlan::tableName()." WHERE teacher ->> '1' = '".$teacher_id."' OR teacher ->> '2' = '".$teacher_id."'";
        $data = PracticePlan::findBySql($sql)->all();
        $teacher = Employee::findOne($teacher_id);

        return $this->render('practice/teacher-view', [
            'data' => $data,
            'teacher' => $teacher,
        ]);
    }

    public function actionTeacher()
    {
        $searchModel = new EmployeeSearch($this->institution);
        $searchModel->status = Employee::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('teacher', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTeacherView($teacher_id)
    {
        $teacher = Employee::findOne($teacher_id);

        $required = RequiredDisciplines::find()
                ->joinWith('teacherCourse')
                ->where([TeacherCourse::tableName().'.teacher_id' => $teacher_id])
                ->joinWith('institutionDiscipline')
                ->andWhere([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id])
                ->all();

        $optional = OptionalDisciplines::find()
                ->where(['teacher_id' => $teacher_id])
                ->joinWith('institutionDiscipline')
                ->andWhere([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id])
                ->all();

        $facultatives = Facultative::find()
                ->where([Facultative::tableName().'.teacher_id' => $teacher_id])
                ->all();

        $sql = "SELECT * FROM ".PracticePlan::tableName()." WHERE teacher ->> '1' = '".$teacher_id."' OR teacher ->> '2' = '".$teacher_id."'";
        $practices = PracticePlan::findBySql($sql)->all();

        return $this->render('teacher-view', [
            'teacher' => $teacher,
            'required' => $required,
            'optional' => $optional,
            'facultatives' => $facultatives,
            'practices' => $practices,
        ]);
    }
}
