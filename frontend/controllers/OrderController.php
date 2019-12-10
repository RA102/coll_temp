<?php

namespace frontend\controllers;

use common\models\organization\Classroom;
use frontend\search\ClassroomSearch;
use common\models\person\Employee;
use common\models\person\Person;
use common\models\person\Student;
use common\services\organization\GroupService;
use common\services\person\PersonService;
use frontend\models\forms\GroupAllocationForm;
use frontend\search\GroupSearch;
use frontend\search\EmployeeSearch;
use frontend\search\StudentSearch;
use Yii;
use common\models\organization\Group;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class OrderController extends Controller
{
    public $groupService;
    private $personService;

    public function __construct(string $id, $module, GroupService $groupService, PersonService $personService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->groupService = $groupService;
        $this->personService = $personService;
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ClassroomSearch();
        $searchModel->institution_id = Yii::$app->user->identity->institution->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGroups($template)
    {
        $searchModel = new GroupSearch();
        $searchModel->institution_id = Yii::$app->user->identity->institution->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('groups', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'template' => $template,
        ]);
    }

    public function actionStudents($template)
    {
    	$searchModel = new StudentSearch();
        $searchModel->status = Student::STATUS_ACTIVE;
        $searchModel->institution_id = Yii::$app->user->identity->institution->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('students', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'template' => $template,
        ]);
    }

    /**
     * Lists all Employee models.
     * @return mixed
     */
    public function actionEmployee($template)
    {
        $searchModel = new EmployeeSearch(Yii::$app->user->identity->institution);
        $searchModel->status = Employee::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $title = $this->orderNames($template, 'employee');

        return $this->render('employee', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'template' => $template,
            'title' => $title,
        ]);
    }

    public function orderNames($template, $person)
    {
        if ($person == 'student') {
            $orders = [
                '01' => 'Приказ о восстановлении',
                '02' => 'Приказ о переводе',
                '03' => 'Приказ об отчислении',
                '04' => 'Приказ о вручении диплома',
                '05' => 'Приказ о допуске к госэкзаменам',
                '06' => 'Приказ о назначении стипендии',
                '07' => 'Приказ о направлении на практику',
                '08' => 'Приказ об условном переводе',
                '09' => 'Приказ о дорожных расходах',
                '10' => 'Приказ о льготах',
                '11' => 'Приказ о питании',
                '12' => 'Приказ о переводе госзаказа',
                '13' => 'Справка об обучении',
                '14' => 'Справка о подтверждении диплома',
            ];
        }
        else {
            $orders = [
                '01' => 'Приказ по личному составу',
                '02' => 'Прием на работу',
                '03' => 'Увольнение',
                '04' => 'Приказ на командировку',
                '05' => 'О повышении квалификации',
                '06' => 'Порицание',
                '07' => 'Поощрение',
                '08' => 'Список кафедр',
                '09' => 'Справка для сотрудников',
                '10' => 'Без содержания',
                '11' => 'Декретный отпуск',
            ];
        }

        return $orders[$template];
    }

    public function actionStudentOrder($student_id, $template)
    {
        $student = Student::findOne($student_id);
        $groups = $this->groupService->getGroups(Yii::$app->user->identity->institution);

        if ($template == '01') {
            $model = new \yii\base\DynamicModel(['new_group', 'note', 'year']);
        }
        elseif ($template == '02') {
            $model = new \yii\base\DynamicModel(['group', 'new_group', 'note', 'year']);
        }
        elseif ($template == '03') {
            $model = new \yii\base\DynamicModel(['group', 'new_group', 'note', 'year']);
        }
        elseif ($template == '10') {
            $model = new \yii\base\DynamicModel(['season', 'discount']);
        }
        elseif ($template == '11') {
            $model = new \yii\base\DynamicModel(['season', 'note', 'semester', 'amount']);
        }
        elseif ($template == '12') {
            $model = new \yii\base\DynamicModel(['date']);
        }
        elseif ($template == '13') {
            return $this->redirect(['export', 'student_id' => $student_id, 'template' => $template]);
        }
        elseif ($template == '14') {
            return $this->redirect(['export', 'student_id' => $student_id, 'template' => $template]);
        }

        if ($model->load(Yii::$app->request->post())) {
            $data = [];
            $data['group'] = $student->group->caption_current;

            $filename = \Yii::$app->basePath . '/web/' . '_' . $student->firstname . '_' . $student->lastname . ':' . $this->orderNames($template, 'student') . '.docx';

            if (file_exists($filename)) {
                unlink($filename);
            }

            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('templates/student/' . $template . '.docx');
            $templateProcessor->setValue('name', $student->firstname . ' ' . $student->lastname);
            $templateProcessor->setValue('class', $student->group->class);
            $templateProcessor->setValue('group', $student->group->caption_current);
            $templateProcessor->setValue('speciality', $student->group->speciality->caption_current);
            $templateProcessor->setValue('director', Yii::$app->user->identity->institution->director);
            if (array_key_exists('new_group', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('new_group', $_POST['DynamicModel']['new_group']);
            }
            if (array_key_exists('note', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('note', $_POST['DynamicModel']['note']);
            }
            if (array_key_exists('year', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('year', $_POST['DynamicModel']['year']);
            }
            if (array_key_exists('season', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('season', $_POST['DynamicModel']['season']);
            }
            if (array_key_exists('discount', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('discount', $_POST['DynamicModel']['discount']);
            }
            if (array_key_exists('amount', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('amount', $_POST['DynamicModel']['amount']);
            }
            if (array_key_exists('semester', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('semester', $_POST['DynamicModel']['semester']);
            }     
            if (array_key_exists('date', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('date', $_POST['DynamicModel']['date']);
            }          
            $templateProcessor->saveAs($filename);
            
            return Yii::$app->response->sendFile($filename);

        }

        return $this->render('student/' . $template, [
            'student' => $student,
            'model' => $model,
            'groups' => $groups,
        ]);
    }

    public function actionGroupOrder($group_id, $template)
    {
        $group = Group::findOne($group_id);
        $groups = $this->groupService->getGroups(Yii::$app->user->identity->institution);
        $students = $group->students;

        $students_array = [];
        foreach ($students as $key => $value) {
            $students_array[$key]['number'] = $key + 1;
            $students_array[$key]['name'] = $value->fullName;
        }

        if ($template == '05') {
            $model = new \yii\base\DynamicModel(['season', 'date']);
        }
        elseif ($template == '06') {
            $model = new \yii\base\DynamicModel(['season', 'date', 'semester']);
        }
        elseif ($template == '07') {
            $model = new \yii\base\DynamicModel(['season', 'from', 'to', 'place']);
        }
        elseif ($template == '08') {
            $model = new \yii\base\DynamicModel(['season', 'year', 'new_class']);
        }

        if ($model->load(Yii::$app->request->post())) {
            $data = [];
            $data['group'] = $group->caption_current;

            $filename = \Yii::$app->basePath . '/web/' . '_' . $group->caption_current . ':' . $this->orderNames($template, 'student') . '.docx';

            if (file_exists($filename)) {
                unlink($filename);
            }

            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('templates/student/' . $template . '.docx');

            $templateProcessor->setValue('group', $group->caption_current);
            $templateProcessor->setValue('speciality', $group->speciality->caption_current);
            $templateProcessor->cloneBlock('students_block', 0, true, false, $students_array);
            $templateProcessor->setValue('class', $group->class);
            $templateProcessor->setValue('total_graduates', count($students));
            $templateProcessor->setValue('director', Yii::$app->user->identity->institution->director);
            if (array_key_exists('date', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('date', $_POST['DynamicModel']['date']);
            }
            if (array_key_exists('season', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('season', $_POST['DynamicModel']['season']);
            }
            if (array_key_exists('semester', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('semester', $_POST['DynamicModel']['semester']);
            }
            if (array_key_exists('from', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('from', $_POST['DynamicModel']['from']);
            }
            if (array_key_exists('to', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('to', $_POST['DynamicModel']['to']);
            }
            if (array_key_exists('place', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('place', $_POST['DynamicModel']['place']);
            }
            if (array_key_exists('year', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('year', $_POST['DynamicModel']['year']);
            }
            if (array_key_exists('new_class', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('new_class', $_POST['DynamicModel']['new_class']);
            }
            $templateProcessor->saveAs($filename);
            
            return Yii::$app->response->sendFile($filename);

        }

        return $this->render('group/' . $template, [
            'model' => $model,
            'group' => $group,
            'groups' => $groups,
        ]);
    }

    public function actionEmployeeOrder($employee_id, $template)
    {
        $employee = Employee::findOne($employee_id);

        if ($template == '02') {
            $model = new \yii\base\DynamicModel(['date', 'position']);
        }
        elseif ($template == '03') {
            $model = new \yii\base\DynamicModel(['date', 'position', 'unused_vacation_days', 'application_date']);
        }
        elseif ($template == '04') {
            $model = new \yii\base\DynamicModel(['from', 'to', 'city']);
        }
        elseif ($template == '05') {
            $model = new \yii\base\DynamicModel(['from', 'to', 'college', 'days']);
        }
        elseif ($template == '06') {
            $model = new \yii\base\DynamicModel(['discipline']);
        }
        elseif ($template == '07') {
            $model = new \yii\base\DynamicModel(['from', 'reason', 'percent', 'note']);
        }
        elseif ($template == '09') {
            $model = new \yii\base\DynamicModel(['date', 'salary']);
        }
        elseif ($template == '10') {
            $model = new \yii\base\DynamicModel(['from', 'to', 'note']);
        }
        elseif ($template == '11') {
            $model = new \yii\base\DynamicModel(['from', 'to', 'application_date']);
        }


        if ($model->load(Yii::$app->request->post())) {
            $filename = \Yii::$app->basePath . '/web/' . '_' . $employee->firstname . ' ' . $employee->lastname . ':' . $this->orderNames($template, 'employee') . '.docx';

            if (file_exists($filename)) {
                unlink($filename);
            }

            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('templates/employee/' . $template . '.docx');

            $templateProcessor->setValue('name', $employee->fullName);
            $templateProcessor->setValue('director', Yii::$app->user->identity->institution->director);
            $templateProcessor->setValue('college', Yii::$app->user->identity->institution->name);
            if (array_key_exists('date', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('date', $_POST['DynamicModel']['date']);
            }
            if (array_key_exists('position', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('position', $_POST['DynamicModel']['position']);
            }
            if (array_key_exists('unused_vacation_days', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('unused_vacation_days', $_POST['DynamicModel']['unused_vacation_days']);
            }
            if (array_key_exists('application_date', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('application_date', $_POST['DynamicModel']['application_date']);
            }
            if (array_key_exists('from', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('from', $_POST['DynamicModel']['from']);
            }
            if (array_key_exists('to', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('to', $_POST['DynamicModel']['to']);
            }
            if (array_key_exists('city', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('city', $_POST['DynamicModel']['city']);
            }
            if (array_key_exists('college', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('college', $_POST['DynamicModel']['college']);
            }
            if (array_key_exists('days', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('days', $_POST['DynamicModel']['days']);
            }
            if (array_key_exists('discipline', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('discipline', $_POST['DynamicModel']['discipline']);
            }
            if (array_key_exists('salary', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('salary', $_POST['DynamicModel']['salary']);
            }
            if (array_key_exists('note', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('note', $_POST['DynamicModel']['note']);
            }
            if (array_key_exists('reason', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('reason', $_POST['DynamicModel']['reason']);
            }
            if (array_key_exists('percent', $_POST['DynamicModel'])) {
                $templateProcessor->setValue('percent', $_POST['DynamicModel']['percent']);
            }
            $templateProcessor->saveAs($filename);
            
            return Yii::$app->response->sendFile($filename);
        }

        return $this->render('employee/' . $template, [
            'employee' => $employee,
            'model' => $model,
        ]);
    }

    public function actionExport($student_id, $template, $data=null)
    {
    	$student = Student::findOne($student_id);

    	$filename = \Yii::$app->basePath . '/web/' . '_' . $student->firstname . '_' . $student->lastname . ':' . $this->orderNames($template, 'student') . '.docx';

        if (file_exists($filename)) {
            unlink($filename);
        }

		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('templates/student/' . $template . '.docx');
		$templateProcessor->setValue('name', $student->firstname . ' ' . $student->lastname);
        $templateProcessor->setValue('class', $student->group->class);
        $templateProcessor->setValue('group', $student->group->caption_current);
        $templateProcessor->setValue('speciality', $student->group->speciality->caption_current);
        $templateProcessor->setValue('education_form', $student->group->educationForm);
        $templateProcessor->setValue('new_group', $data['new_group']);
        $templateProcessor->setValue('note', $data['note']);
		$templateProcessor->setValue('year', $data['year']);
        $templateProcessor->setValue('director', Yii::$app->user->identity->institution->director);
		$templateProcessor->saveAs($filename);
		
		return Yii::$app->response->sendFile($filename);

        //return $this->redirect(['index']);
    }

    public function actionExportEmployeeOrder($employee_id, $template, $data=null)
    {
        $employee = Employee::findOne($employee_id);

        $filename = \Yii::$app->basePath . '/web/' . '_' . $employee->firstname . '_' . $employee->lastname . ':' . $this->orderNames($template, 'employee') . '.docx';

        if (file_exists($filename)) {
            unlink($filename);
        }

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('templates/employee/' . $template . '.docx');
        $templateProcessor->setValue('name', $employee->firstname . ' ' . $employee->lastname);
        $templateProcessor->setValue('director', Yii::$app->user->identity->institution->director);
        $templateProcessor->saveAs($filename);
        
        return Yii::$app->response->sendFile($filename);


        //return $this->redirect(['index']);
    }

    public function actionExportGroupOrder($group_id, $template)
    {
        $group = Group::findOne($group_id);
        $students = $group->students;

        $students_array = [];
        foreach ($students as $key => $value) {
            $students_array[$key]['number'] = $key + 1;
            $students_array[$key]['name'] = $value->fullName;
        }

        $filename = \Yii::$app->basePath . '/web/' . '_' . $group->caption_current . '_' . $this->orderNames($template, 'student') . '.docx';

        if (file_exists($filename)) {
            unlink($filename);
        }

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('templates/student/' . $template . '.docx');
        $templateProcessor->setValue('group', $group->caption_current);
        $templateProcessor->setValue('speciality', $group->speciality->caption_current);
        $templateProcessor->cloneBlock('students_block', 0, true, false, $students_array);
        $templateProcessor->setValue('class', $group->class);
        $templateProcessor->setValue('total_graduates', count($students));
        $templateProcessor->setValue('director', Yii::$app->user->identity->institution->director);
        $templateProcessor->saveAs($filename);
        
        return Yii::$app->response->sendFile($filename);


        //return $this->redirect(['index']);
    }

    public function actionCreate()
    {
        $model = new Classroom();
        $model->institution_id = Yii::$app->user->identity->institution->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Classroom::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
