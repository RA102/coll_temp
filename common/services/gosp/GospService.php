<?php

namespace common\services\gosp;

use Codeception\Lib\Console\Message;
use yii\db\ActiveQuery;
use Karriere\JsonDecoder\JsonDecoder;
use common\models\gosp;
use common\models\gosp\InputMessage;
use common\models\gosp\MessageStatuses;
use common\models\gosp\MessageStatusBody;
use common\models\organization\Institution;
//use common\models\reception;
use common\models\reception\AdmissionApplication;

use frontend\models\forms\AdmissionApplicationForm;
use common\models\person\Person;
use common\models\reception\AdmissionFiles;
use common\services\reception\AdmissionApplicationService;
use common\services\reception\CommissionService;



class GospService
{
    const SYSTEMID = "college"; //заявка создана

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
        $msgs = InputMessage::find()->limit(1)->orderBy('id ASC')->all();
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


    private function uploadFile($file, $fileName)
    {
        //загрузка  на файл-сервер
        $post = [
            'Upload[file]'=> new \CURLFile(
                $file,
                mime_content_type($file),
                $fileName
            ),
            'Upload[name]' => $fileName
        ];
        $ch = curl_init('https://ff.bilimal.kz/upload');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);    
        $response = json_decode($result, true);
        if ($response !== null && isset($response['host']) && isset($response['url'])) {
            return $response;
        }    return false;
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
        $person_id = null; 

        if ($person != null && $person->id>0 ) {
            $aapp->person_id = $person->id;
            $person_id = $person->id; 

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
                    $institution->id,
                    $person_id
                );
                
                if ($admissionApplication != null){
                    //update message status
                    $aapp = $admissionApplication;
                }

            }
    
        }

        //обработка файлов
        foreach($jsarr as $js){
            $dbfilename = null;
            $filebody = null;
            $doc_type = "unknown";
            $file_meta = "";
            $url = "";

            //вид документа
            if ($js['name'] == "Foto" && $js['datatype'] == "fileData"){
                $doc_type = AdmissionFiles::DOC_TYPE_PHOTO;

                $farr = explode(';', $js['value']);
                if ($farr[0] != null){
                    $dbfilename = $farr[0];

                }
                if ($farr[1] != null){
                    $filebody = base64_decode($farr[1]);
                }
            }

            if ($dbfilename != null && $filebody != null){
                $file = \Yii::getAlias('@runtime') . '/' . time();
                file_put_contents($file, $filebody);
                $extension = pathinfo($dbfilename, PATHINFO_EXTENSION);
                $fileName = $dbfilename . ($extension ? '' : '.jpg');

                ///upload file
                $responce = true; //
                $responce = $this->uploadFile($file, $fileName);

                if ($responce){
                    //succedd upload,  save record
                    $aa_id = null;
                    $person_id = null;

                    if ($aapp != null){
                        $aa_id = $aapp->id;
                        $person_id = $aapp->person_id;
                    }

                    $file_meta = json_encode($responce);
                    if ($responce['url'] != null){
                        $url = $responce['url'];
                    }

                    $dbf = AdmissionFiles::add($doc_type, $file_meta, $url, $aa_id, $person_id);
                    if ($dbf->getIsNew()){
                        $sv = $dbf->save();
                    }
                    
                }
            }


        }

        return $aapp->id;

    }

    public function sendNotification(MessageStatusBody $body, String $status){
        //$entrant = Person::findOne($entrant_id);
        
        $db_msg = new MessageStatuses();
        $db_msg->messagestatus = MessageStatuses::STATE_NOTIFICATED;
        $db_msg->messageid = $body->messageId;
        $db_msg->systemid = $this->SYSTEMID;
        $db_msg->status_body = json_encode($body);

        return "ok";
    }

    public function sendResponse(MessageStatusBody $body, String $status){
        //$entrant = Person::findOne($entrant_id);
        
        $db_msg = new MessageStatuses();
        $db_msg->messagestatus = MessageStatuses::STATE_NOTIFICATED;
        $db_msg->messageid = $body->messageId;
        $db_msg->systemid = $this->SYSTEMID;
        $db_msg->status_body = json_encode($body);

        return "ok";
    }    
}