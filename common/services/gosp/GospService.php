<?php

namespace common\services\gosp;

use yii\db\ActiveQuery;
use Karriere\JsonDecoder\JsonDecoder;
use common\models\gosp;
use common\models\gosp\InputMessage;
//use common\models\reception;
use common\models\reception\AdmissionApplication;

use frontend\models\forms\AdmissionApplicationForm;
use common\models\person\Person;

use common\services\reception\AdmissionApplicationService;



class GospService
{
    private $jsonDecoder;
    private $admissionApplicationService;

    public function __construct(
        AdmissionApplicationService $admissionApplicationService
    )
    {
        $this->jsonDecoder = new JsonDecoder();
        $this->admissionApplicationService = $admissionApplicationService;

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
        }
        
        return $msgs;
    }

    private function mapMessageToAdmApp(String $msg){
        $person_iin="";
        $person_name="";
        $person_surname="";
        $person_middlename="";

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

        }

        //=========== обработка person
        $person = Person::find()->where(['iin' => $person_iin])->One();
        if ($person == null) {
            //создаем нового

        }
        else {
            //сверяем его данные, и обновляем автуальными с egov
        }

        //=========== обработка Заявления        

        
        $aapp = new AdmissionApplication();

        $aaForm = new AdmissionApplicationForm();
        

        $aapp->status =0;
        $aapp->institution_id=1; //тут подбор университета
        if ($person != null && $person->id>0 ) {
            $aapp->person_id = $person->id;

            $aaForm->iin = $person_iin;
        }

        // $admissionApplication = $this->admissionApplicationService->create(
        //     $admissionApplicationForm,
        //     $commission->id,
        //     Yii::$app->user->identity->institution->id
        // );

        return $aapp;

    }
}