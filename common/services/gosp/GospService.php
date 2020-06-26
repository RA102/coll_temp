<?php

namespace common\services\gosp;

use Codeception\Lib\Console\Message;
use common\helpers\ApplicationHelper;
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
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\base\Exception;
use common\helpers\EducationHelper;
use common\models\handbook\Speciality;

class GospService
{
    const SYSTEMID = "college"; //заявка создана
    const SHEP_URL_SERVICE = "https://api.bilimal.kz/gosr/restservice/"; //"http://localhost:8085/restservice/"; //
    const SHEP_NOTIF_CONFIG = "mnp-prod"; // "mnp-test"
    const SRV_TYPE_COLLEGE = "RR_S109";

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
        $msgs = InputMessage::find()->where(['servicetype' => self::SRV_TYPE_COLLEGE, 'messagestatus' => 0, 'recstatus' => 0])
        ->andWhere(['is not', 'serviceproviderbin', null])
        ->limit(20)->orderBy('id ASC')->all();
        foreach($msgs as $msg){
            $ap = $this->mapMessageToAdmApp($msg->messageid, $msg->parsedmessage, $msg->orgnameru, $msg->orgnamekz);
            
            if ($ap != null && $ap>0){
                //update status to accepted
                $ms = new MessageStatuses();
                $ms->systemid = $this::SYSTEMID;
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

    private function getInstitutionByBin(String $bin){
        $result = new Institution(); //24 - хогвардс
        $institution = Institution::find()->where(['bin' => $bin])->one();
        if ($institution != null){
            $result = $institution;
            $institution = Institution::findOne(1);
        }
        if ($institution == null){
            $result = Institution::findOne(1);
        }

        return $result;
    }

    private function mapMessageToAdmApp(String $msg_id, String $msg, String $ru_name, String $kk_name){
        $person_iin="";
        $person_name="";
        $person_surname="";
        $person_middlename="";
        $person_birthdate="";
        $serviceProviderBin="";
        $education_form = 1;          //Основа обучения очное/заочное
        $speciality_id = 0;        //Специальность
        $dormitory_info_tipo="";
        $needs_dormitory = false;     //Необходимость в общежитии да/нет
        $language = 'ru';                //Язык обучения
        $lang_edu_tipo ="";
      

        $person = new Person();
        
        $jsarr = json_decode($msg, true);
        foreach($jsarr as $js){

            if ($js['name'] == "requesterIin"){
                $person_iin = $js['value'];
            }
            if ($js['name'] == "user_name"){
                $person_name = $js['value'];
            }
            if ($js['name'] == "user_surname"){
                $person_surname = $js['value'];
            }                        
            if ($js['name'] == "user_middlename"){
                $person_middlename = $js['value'];
            } 
            if ($js['name'] == "user_birthday"){
                $person_birthdate = $js['value'];
                $person_birthdate = substr($person_birthdate, 0, 10);
            }  
            if ($js['name'] == "serviceProviderBin"){
                $serviceProviderBin = $js['value'];
            }            
            if ($js['name'] == "edu_form_tipo"){
                $education_form = EducationHelper::EDUCATION_FORM_FULL_TIME;
                $str_edu_form = $js['value'];
                if ($str_edu_form == "1"){
                    $education_form == EducationHelper::EDUCATION_FORM_EXTRAMURAL; //заочная
                } 
                if ($str_edu_form == "2"){
                    $education_form == EducationHelper::EDUCATION_FORM_EVENING; //вечерняя
                } 
            }       

            if ($js['name'] == "postSecondary_spec_code"){
                $scode = $js['value'];
                $sp = Speciality::find()->where(['code' => $scode])->one();
                if ($sp != null){
                    $speciality_id = $sp->id;
                }
            }
            if ($js['name'] == "dormitory_info_tipo"){
                $dormitory_info_tipo = $js['value'];
                if ($dormitory_info_tipo == 'true'){
                    $needs_dormitory = true;     //Необходимость в общежитии да/нет
                }
                
            }   
            if ($js['name'] == "lang_edu_tipo"){
                $lang_edu_tipo = $js['value'];
                if ($lang_edu_tipo == '01'){
                    $language = 'kk';     //казахский
                }
                if ($lang_edu_tipo == '02'){
                    $language = 'ru';     //казахский
                }                
            } 

            if ($js['name'] == "kk_name"){
                $kk_name = $js['value'];
            } 
            if ($js['name'] == "ru_name"){
                $ru_name = $js['value'];
            } 
        }

        $institution_id = 24; //хогвардс
        $institution = $this->getInstitutionByBin($serviceProviderBin);          //тут подбор университета
        if ($institution!= null){
            $institution_id = $institution->id;

            if (strlen($kk_name)<2){
                $kk_name = $institution->name;
            }
            if (strlen($ru_name)<2){
                $ru_name = $institution->name;
            }
        }
        
        $filing_form = 2;             //Заявка подана Онлайн
        $education_pay_form = EducationHelper::EDUCATION_PAY_FORM_CONTRACT;      //Форма оплаты
        $based_classes = ApplicationHelper::BASED_CLASSES_ELEVEN;           //На базе 9 классов/11 классов

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
            //$person->sex = 1;
            //$person->nationality_id = 1;
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
            //$aaForm->citizenship_location = 1;

            $aaForm->filing_form = $filing_form;                    //Заявка подана Онлайн
            $aaForm->education_form = $education_form;              //Основа обучения очное/заочное
            $aaForm->speciality_id = $speciality_id;                //Специальность
            $aaForm->language = $language;                          //Язык обучения

            $aaForm->needs_dormitory = $needs_dormitory;            //Необходимость в общежитии да/нет

            $aaForm->education_pay_form = $education_pay_form;      //Форма оплаты
            $aaForm->based_classes = $based_classes;                //На базе 9 классов/11 классов
            $aaForm->application_date = date("Y-m-d");              //Дата подачи заявления
            $aaForm->online = 1;
            $aaForm->online_msg_id = $msg_id;
            
            $aaForm->kk_name = $kk_name;
            $aaForm->ru_name = $ru_name;
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
        $result = "";
        $db_msg = new MessageStatuses();
        $db_msg->messagestatus = MessageStatuses::STATE_NOTIFICATED;
        $db_msg->messageid = $body->messageId;
        $db_msg->systemid = $this::SYSTEMID;
        $db_msg->status_body = ArrayHelper::toArray($body); //json_encode(ArrayHelper::toArray($body));
        if (!$db_msg->save()){
            $result = "Ошибка сохранения оповещения заявки";
        }
        
        $this->sendApiResponse($body->messageId);
        return $result;
    }

    public function sendResponse(MessageStatusBody $body, String $status){
        $result = "";
        
        $db_msg = new MessageStatuses();
        $db_msg->messagestatus = MessageStatuses::STATE_SUCCESS;
        if ($body->resolutionType == "NEGATIVE"){
            $db_msg->messagestatus = MessageStatuses::STATE_REJECTED;
        }

        $db_msg->messageid = $body->messageId;
        $db_msg->systemid = $this::SYSTEMID;
        $db_msg->status_body = ArrayHelper::toArray($body);

        if (!$db_msg->save()){
            $result = "Ошибка сохранения ответа заявки";
        }

        $this->sendApiResponse($body->messageId);
        return $result;
    }
    
    private function sendApiResponse(String $msg_id){
        $client = new Client(['baseUrl' => self::SHEP_URL_SERVICE]);
        $response = $client->createRequest()
            ->setOptions([
                'timeout' => 120,
            ])
            ->setMethod('POST')
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('sendXMLMessageResponse')
            ->setData([
                'config' => self::SHEP_NOTIF_CONFIG,
                'messageId' => $msg_id,
            ])
            ->send();    if (!$response->isOk) {
            throw new Exception($response->getContent());
        }        
    }
}