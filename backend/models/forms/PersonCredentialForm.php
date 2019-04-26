<?php

namespace backend\models\forms;

use common\models\person\PersonCredential;
use yii\base\Model;

class PersonCredentialForm extends Model
{
    public $indentity;

    public function rules()
    {
        return [
            ['indentity', 'required'],
            ['indentity', 'email'],
            [
                'indentity',
                'unique',
                'targetClass' => PersonCredential::class,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'indentity' => 'Авторизационная запись'
        ];
    }
}
