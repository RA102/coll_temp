<?php

namespace frontend\models\forms;

use common\helpers\PersonCredentialHelper;
use common\models\person\Person;
use common\services\pds\PersonCredentialService;
use Yii;
use yii\base\Model;

class EntranceExamOrderForm extends Model
{
    public $date;
    public $number;
    public $protocol_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'number', 'protocol_id'], 'required'],
            ['protocol_id', 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'date' => Yii::t('app', 'Date'),
            'number' => Yii::t('app', 'Number'),
            'protocol_id' => Yii::t('app', 'Protocol number'),
        ];
    }
}
