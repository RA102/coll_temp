<?php

namespace frontend\models\forms;

use common\models\person\Person;
use common\models\person\PersonCredential;
use yii\base\Model;

class PersonCredentialForm extends Model
{
    public $person_id;
    public $indentity;

    public function rules()
    {
        return [
            ['person_id', 'required'],
            ['person_id', 'integer'],
            [
                'person_id',
                'exist',
                'targetClass'     => Person::class,
                'targetAttribute' => 'id',
                'filter'          => ['status' => Person::STATUS_ACTIVE]
            ],
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
            'person_id' => 'Пользователь', // depends on context (Employee or student)
            'indentity' => 'Авторизационная запись'
        ];
    }
}