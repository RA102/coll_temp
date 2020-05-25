<?php

namespace common\services\gosp;

use Codeception\Lib\Console\Message;
use yii\db\ActiveQuery;
use Karriere\JsonDecoder\JsonDecoder;
use common\models\gosp;
use common\models\gosp\InputMessage;
use common\models\gosp\MessageStatuses;
use common\models\organization\Institution;
//use common\models\reception;
use common\models\reception\AdmissionApplication;

use frontend\models\forms\AdmissionApplicationForm;
use common\models\person\Person;

use common\services\reception\AdmissionApplicationService;
use common\services\reception\CommissionService;



class GospService
{
    private $jsonDecoder;
    private $admissionApplicationService;
    private $commissionService;

    public function __construct(
        AdmissionApplicationService $admissionApplicationService,
        CommissionService $commissionService
    )
    {
        $this->jsonDecoder = new JsonDecoder();
        $this->admissionApplicationService = $admissionApplicationService;
        $this->commissionService = $commissionService;

    }

    /**
     * @param  $ins
     * @return 
     */
    public function getInputMessages()
    {
        // TODO teacherCourse is eager loaded, should it be a separate method?
        $msgs = InputMessage::find()->limit(1)->orderBy('id DESC')->all();
        foreach($msgs as $msg){
            $ap = $this->mapMessageToAdmApp($msg->parsedmessage);
            
            if ($ap != null && $ap>0){
                //update status to accepted
                $ms = new MessageStatuses();
                $ms->systemid = "college";
                $ms->messageid = $msg->messageid;
                $ms->messagestatus = MessageStatuses::STATE_RECEIVED;
                $ms->save();
            }
        }
        
        return $msgs;
    }

    private function mapMessageToAdmApp(String $msg){
        $person_iin="";
        $person_name="";
        $person_surname="";
        $person_middlename="";
        $person_birthdate="";

        $person = new Person();
        
        $jsarr = json_decode($msg, true);
        foreach($jsarr as $js){
            if ($js['name'] == "Child_iin"){
                $person_iin = $js['value'];
            }
            if ($js['name'] == "child_name"){
                $person_name = $js['value'];
            }
            if ($js['name'] == "child_surname"){
                $person_surname = $js['value'];
            }                        
            if ($js['name'] == "child_middlename"){
                $person_middlename = $js['value'];
            } 
            if ($js['name'] == "child_birthday"){
                $person_birthdate = $js['value'];
                $person_birthdate = substr($person_birthdate, 0, 10);
            }                                     

        }

        $institution_id = 1;          //тут подбор университета
        $filing_form = 2;             //Заявка подана Онлайн
        $education_form = 1;          //Основа обучения очное/заочное
        $speciality_id = 1552;        //Специальность
        $language = 1;                //Язык обучения

        $needs_dormitory = false;     //Необходимость в общежитии да/нет

        $education_pay_form = 1;      //Форма оплаты
        $based_classes = 1;           //На базе 9 классов/11 классов


        //=========== обработка person
        $person = Person::find()->where(['iin' => $person_iin])->One();
        if ($person == null) {
            //создаем нового
            $person = new Person();
            $person->iin = $person_iin;
            $person->firstname = $person_name;
            $person->lastname = $person_surname;
            $person->middlename = $person_middlename;
            $person->birth_date = $person_birthdate;
            $person->sex = 1;
            $person->nationality_id = 1;
            $person->status = 1;
            $person->type = 1;
            $person->person_type = 'entrant';
            $person->save();
        }
        else {
            //сверяем его данные, и обновляем автуальными с egov
        }

        //=========== обработка Заявления        

        
        $aapp = new AdmissionApplication();
        $aaForm = new AdmissionApplicationForm();
        

        $aapp->status =0;
        $aapp->institution_id = $institution_id; 

        if ($person != null && $person->id>0 ) {
            $aapp->person_id = $person->id;

            $aaForm->iin = $person_iin;
            
            $aaForm->firstname= $person->firstname;
            $aaForm->lastname = $person->lastname;
            $aaForm->sex = $person->sex;
            $aaForm->birth_date = $person->birth_date;
            $aaForm->application_date = $person_iin;
            $aaForm->nationality_id = $person->nationality_id;
            $aaForm->citizenship_location = 1;

            $aaForm->filing_form = $filing_form;                    //Заявка подана Онлайн
            $aaForm->education_form = $education_form;              //Основа обучения очное/заочное
            $aaForm->speciality_id = $speciality_id;                //Специальность
            $aaForm->language = $language;                          //Язык обучения

            $aaForm->needs_dormitory = $needs_dormitory;            //Необходимость в общежитии да/нет

            $aaForm->education_pay_form = $education_pay_form;      //Форма оплаты
            $aaForm->based_classes = $based_classes;                //На базе 9 классов/11 классов
            $aaForm->application_date = date("Y-m-d");              //Дата подачи заявления

        }

        $institution = Institution::findOne($institution_id);

        if ($institution != null){
            $commission = $this->commissionService->getActiveInstitutionCommission(
                $institution
            );

            if ($commission != null){
                $admissionApplication = $this->admissionApplicationService->create(
                    $aaForm,
                    $commission->id,
                    $institution->id
                );
                
                if ($admissionApplication != null){
                    //update message status
                    $aapp = $admissionApplication;
                }
                

            }
    
        }


        return $aapp->id;

    }
}