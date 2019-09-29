<?php

namespace frontend\controllers;

use common\models\Facultative;
use common\models\RequiredDisciplines;
use common\models\OptionalDisciplines;
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
use frontend\search\EmployeeSearch;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PlanController extends Controller
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

    public function actionRequired()
    {
        $query = RequiredDisciplines::find()
                ->joinWith('institutionDiscipline')
                ->where([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('required',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOptional()
    {
        $query = OptionalDisciplines::find()
                ->joinWith('institutionDiscipline')
                ->where([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('optional',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFacultative()
    {
        $query = Facultative::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('facultative',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateRequired()
    {
        $institutionDisciplines = $this->institutionDisciplineService->getInstitutionDisciplines($this->institution);
        $groups = Group::find()->where(['institution_id' => $this->institution->id])->all();
        $teachers = $this->employeeService->getTeachers($this->institution);

        $model = new RequiredDisciplines();

        if ($model->load(Yii::$app->request->post())) {
            $query = RequiredDisciplines::find()
                        ->where(['group_id' => $model->group_id]) 
                        ->andWhere(['discipline_id' => $model->discipline_id])
                        ->one();

            if ($query !== null) {
                Yii::$app->session->setFlash('error',
                    Yii::t('app', 'Данная связка группа-дисциплина уже существует!')); 
                    return $this->redirect(['required']);
            }

            if ($model->save()) {
                return $this->redirect(['required']);
            }
        }

        return $this->render('required/create', [
            'model' => $model,
            'institutionDisciplines' => $institutionDisciplines,
            'groups' => $groups,
            'teachers' => $teachers,
        ]);
    }

    public function actionCreateOptional()
    {
        $institutionDisciplines = $this->institutionDisciplineService->getInstitutionDisciplines($this->institution);
        $groups = Group::find()->where(['institution_id' => $this->institution->id])->all();
        $teachers = $this->employeeService->getTeachers($this->institution);

        $model = new OptionalDisciplines();

        if ($model->load(Yii::$app->request->post())) {
            $query = OptionalDisciplines::find()
                        ->where(['teacher_id' => $model->teacher_id]) 
                        ->andWhere(['discipline_id' => $model->discipline_id])
                        ->one();

            if ($query !== null) {
                Yii::$app->session->setFlash('error',
                    Yii::t('app', 'Данная связка преподаватель-дисциплина уже существует!')); 
                    return $this->redirect(['optional']);
            }

            if ($model->save()) {
                return $this->redirect(['optional']);
            }
        }

        return $this->render('optional/create', [
            'model' => $model,
            'institutionDisciplines' => $institutionDisciplines,
            'groups' => $groups,
            'teachers' => $teachers,
        ]);
    }

    public function actionCreateFacultative()
    {
        $teacherCourses = TeacherCourse::find()->where(['type' => 7])->all();
        $groups = Group::find()->where(['institution_id' => $this->institution->id])->all();
        $teachers = $this->employeeService->getTeachersActive($this->institution);

        $model = new Facultative();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['facultative']);
            }
        }

        return $this->render('facultative/create', [
            'model' => $model,
            'teacherCourses' => $teacherCourses,
            'groups' => $groups,
            'teachers' => $teachers,
        ]);
    }

    public function actionViewRequired($id)
    {
        $model = RequiredDisciplines::findOne($id);
        
        return $this->render('required/view', [
            'model' => $model,
        ]);
    }

    public function actionKtpCreate($id)
    {
        $model = RequiredDisciplines::findOne($id);

        $formmodel = new \yii\base\DynamicModel(['week', 'lesson_number', 'lesson_topic', 'type']);

        if ($formmodel->load(Yii::$app->request->post())) {
            $number = $_POST['DynamicModel']['lesson_number'];
            $data[$number] = [];

            $data[$number]['lesson_number'] = $_POST['DynamicModel']['lesson_number'];
            $data[$number]['week'] = $_POST['DynamicModel']['week'];
            $data[$number]['lesson_topic'] = $_POST['DynamicModel']['lesson_topic'];
            $data[$number]['type'] =  $_POST['DynamicModel']['type'];
            
            $modelktp = $model->ktp;            
            array_push($modelktp, $data[$number]);
            $model->ktp = $modelktp;

            if ($model->save()) {
                return $this->redirect(['view-required', 'id' => $id]);
            }
        }
        
        return $this->render('ktp-create', [
            'model' => $model,
            'formmodel' => $formmodel,
        ]);
    }

    public function actionViewOptional($id)
    {
        $model = OptionalDisciplines::findOne($id);
        $groups = Group::find()->where(['institution_id' => $this->institution->id])->all();
        $students_ids = $model->students;
        $students_array = [];
        foreach ($students_ids as $student_id) {
            $student = Student::findOne($student_id);
            array_push($students_array, $student);
        }

        $formmodel = new \yii\base\DynamicModel(['group']);
        $formmodel->addRule(['group'], 'required');

        return $this->render('optional/view', [
            'model' => $model,
            'groups' => $groups,
            'formmodel' => $formmodel,
            'students' => $students_array,
        ]);
    }

    public function actionViewFacultative($id)
    {
        $model = Facultative::findOne($id);

        return $this->render('facultative/view', [
            'model' => $model,
        ]);
    }

    public function actionAddStudents($id)
    {
        $model = OptionalDisciplines::findOne($id);

        $students = $model->students;

        if (!empty($_POST['DynamicModel'])) {
            $group_id = $_POST['DynamicModel']['group'];
            $group = Group::findOne($group_id);
        }

        if ($model->load(Yii::$app->request->post())) {
            $new_students = $model->students;
            foreach ($new_students as $new) {
                if (!in_array($new, $students)) {
                    array_push($students, $new);
                }
            };
            $model->students = $students;
            if ($model->save()) {
                return $this->redirect(['view-optional', 'id' => $model->id]);
            }
        }

        return $this->render('optional/add-students',[
            'model' => $model,
            'students' => $group->students,
        ]);
    }

    public function actionUpdateRequired($id)
    {
        $model = RequiredDisciplines::findOne($id);

        $institutionDisciplines = $this->institutionDisciplineService->getInstitutionDisciplines($this->institution);
        $groups = Group::find()->where(['institution_id' => $this->institution->id])->all();
        $teachers = $this->employeeService->getTeachersActive($this->institution);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-required', 'id' => $id]);
        }

        return $this->render('required/update', [
            'model' => $model,
            'institutionDisciplines' => $institutionDisciplines,
            'groups' => $groups,
            'teachers' => $teachers,
        ]);
    }

    public function actionUpdateFacultative($id)
    {
        $model = Facultative::findOne($id);

        $teacherCourses = TeacherCourse::find()->where(['type' => 7])->all();
        $groups = Group::find()->where(['institution_id' => $this->institution->id])->all();
        $teachers = $this->employeeService->getTeachersActive($this->institution);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-facultative', 'id' => $id]);
        }

        return $this->render('facultative/update', [
            'model' => $model,
            'teacherCourses' => $teacherCourses,
            'groups' => $groups,
            'teachers' => $teachers,
        ]);
    }

    public function actionDeleteRequired($id)
    {
        $model = RequiredDisciplines::findOne($id);
        $model->delete();

        return $this->redirect(['required']);
    }

    public function actionDeleteOptional($id)
    {
        $model = OptionalDisciplines::findOne($id);
        $model->delete();

        return $this->redirect(['optional']);
    }

    public function actionExams()
    {
        $exams = Exams::find()->all();
        $required = RequiredDisciplines::find()->all();

        $tests = [];
        foreach ($required as $r) {
            foreach ($r->ktp as $key => $value) {
                if ($value['type'] == 8) {
                    array_push($tests, ['group_id' => $r->group_id, 'discipline_id' => $r->discipline_id, 'week' => $value['week']]);
                }
            }
        }

        $course_works = [];
        foreach ($required as $r) {
            foreach ($r->ktp as $key => $value) {
                if ($value['type'] == 3) {
                    array_push($course_works, ['group_id' => $r->group_id, 'discipline_id' => $r->discipline_id, 'week' => $value['week']]);
                }
            }
        }

        return $this->render('exams',[
            'exams' => $exams,
            'tests' => $tests,
            'course_works' => $course_works,
        ]);
    }

    public function actionAddExam()
    {
        $model = new Exams();

        $institutionDisciplines = $this->institutionDisciplineService->getInstitutionDisciplines($this->institution);
        $required = RequiredDisciplines::find()
                ->joinWith('institutionDiscipline')
                ->where([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id]);
        $groups = Group::find()->where(['institution_id' => $this->institution->id])->all();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['exams']);
            }
        }
 
        return $this->render('exams/create', [
            'model' => $model,
            'required' => $required,
            'groups' => $groups,
            'institutionDisciplines' => $institutionDisciplines,
        ]);
    }

    public function actionKtp()
    {
        $groups = Group::find()->where(['institution_id' => $this->institution->id])->all();
        $required = RequiredDisciplines::find()
                ->joinWith('institutionDiscipline')
                ->where([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id]);

        $query = Ktp::find()
                ->joinWith('institutionDiscipline')
                ->where([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id]);

        $institutionDisciplines = $this->institutionDisciplineService->getInstitutionDisciplines($this->institution);

        $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                ]);

        return $this->render('ktp',[
            'dataProvider' => $dataProvider,
            'institutionDisciplines' => $institutionDisciplines,
        ]);
    }

    public function actionCreateKtp()
    {
        $model = new Ktp();

        $institutionDisciplines = $this->institutionDisciplineService->getInstitutionDisciplines($this->institution);
        $required = RequiredDisciplines::find()
                ->joinWith('institutionDiscipline')
                ->where([InstitutionDiscipline::tableName().'.institution_id' => $this->institution->id]);
        $groups = Group::find()->where(['institution_id' => $this->institution->id])->all();
        $teachers = $this->employeeService->getTeachers($this->institution);

        if ($model->load(Yii::$app->request->post())) {
            $week = $_POST['Ktp']['week'];
            $data[$week] = [];

            $data[$week]['lesson_number'] = $_POST['Ktp']['lesson_number'];
            $data[$week]['lesson_topic'] = $_POST['Ktp']['lesson_topic'];
            $data[$week]['type'] =  $_POST['Ktp']['type'];
            //$model->lessons = $_POST['Ktp']['lesson_topic'];
            $model->lessons = $data;
            //var_dump($model->lessons);die();

            if ($model->save()) {
                return $this->redirect(['ktp']);
            }
        }
 
        return $this->render('ktp/create', [
            'model' => $model,
            'required' => $required,
            'groups' => $groups,
            'institutionDisciplines' => $institutionDisciplines,
            'teachers' => $teachers,
        ]);
    }

    public function actionKtpView($id)
    {
        $model = Ktp::findOne($id);

        return $this->render('ktp/view', [
            'model' => $model,
        ]);
    }

}
