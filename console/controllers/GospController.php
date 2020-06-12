<?php


namespace console\controllers;

use yii\console\Controller;
use yii\helpers\ArrayHelper;
use Yii;
use yii\base\Module;

use common\models\gosp\InputMessage;
use common\services\gosp\GospService;
use common\services\reception\AdmissionApplicationService;


/**
 * Description of GospController
 *
 * @author ar
 */
class GospController extends Controller
{
    protected $gospService;
    

    public function __construct(
        string $id,
        Module $module,
        GospService $gospService,
        //AdmissionApplicationService $admissionApplicationService,
        
        array $config = []
    ) {
        $this->gospService = $gospService;
        //$this->admissionApplicationService = $admissionApplicationService;
        parent::__construct($id, $module, $config);
    }    

    public function actionFetchMessages()
    {
        //получение новых записей egov для раскладки
        $msgs = $this->gospService->getInputMessages();
        $cnt = count($msgs);
    }

    




}
