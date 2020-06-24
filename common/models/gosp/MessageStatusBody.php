<?php

namespace common\models\gosp;

use Yii;
use yii\helpers\Json;

/**
 *
 * @property int $id

 * @property string $delete_ts
 * @property int $sort
 *
 
 */
class MessageStatusBody
{
    

    //{"camp": null, "kk_name": "Сәкен Сейфуллин атындағы ЖОББМ", "ru_name": "СОШ им.Сакена Сейфуллина", "freeFood": null, 
    public $Child_iin="";   //"Child_iin": "151005634064"
    public $child_name="";  // "child_name": "СЕРҒАЗЫ"
    public $child_surname="";   //"child_surname": "СЕРҒАЗЫ"
    public $child_middlename="";    //, "child_middlename": "СЕНБЕКҰЛЫ"
    //    , "Class_edu": "03"
    public $messageId=""; //    , "messageId": "171469959"
    public $messageDate="";     //"messageDate": "2020-06-11T17:22:05.428+06:00"
    public $messageType="";     //"messageType": "RESPONSE"
    //public $answer_type_doc="";     //, "answer_type_doc": 3
    //, "serviceId": null
    public $user_name="";   //, "user_name": "МАДИНА"
    public $user_surname="";    //, "user_surname": "БОШТАЕВА"
        //, "user_middlename": "БОГЕНБАЕВНА"
        //, "Language_edu": "03"
        //, "requesterIin": "860717450455"
        
    public $study_form="";                  //0-очная
    public $orderNo_tipo="";
    public $date_orderNo_tipo="";
    public $Output_Type_doc="";             //1 - Уведомление о приеме документов в ТиПО
    public $postSecondary_spec_code="";     //1001022
    public $postSecondary_spec_nameru="";   //100102 2 - Шөміш
    public $postSecondary_spec_namekz="";   //2 - Ковшевой

        //, "correlationId": "2516637"
        //, "orderNo_school": 1
    public $resolutionDate = "";    //, "resolutionDate": "2020-06-11T17:22:05.428+06:00"
    public $resolutionType = "POSITIVE"; //, "resolutionType": "NEGATIVE"
        //, "supervisor_fio": null
        //, "AreaCode_applic": 351013100
        
        
        //, "Class_letter_edu": "А"
        
        //, "externalRequestId": null
    public $processing_status = "COMPLETED";
        //, "serviceProviderBin": null
        //, "date_orderNo_school": "2020-06-11T17:22:05.427+06:00"
        //, "supervisor_position": null
        //, "externalRequestChainId": null
        //, "negativeResolutionReason": null
    public $negativeResolutionReasonTextKk="";        //, "negativeResolutionReasonTextKk": "Ваши документы не приняты"
    public $negativeResolutionReasonTextRu="";        //, "negativeResolutionReasonTextRu": "Ваши документы не приняты"}

}