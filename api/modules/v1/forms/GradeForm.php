<?php

namespace api\modules\v1\forms;

use yii\base\Model;
use Yii;

class GradeForm extends Model
{
    public $value;

    public function formName()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'value' => Yii::t('app', 'Grade Value'),
        ];
    }
}