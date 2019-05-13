<?php

namespace frontend\models\reception\admission_protocol;

use yii\base\Model;

class ProtocolIssueForm extends Model
{
    public $decree;
    public $listeners;
    public $reception_group_id;
    public $speakers;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['decree', 'reception_group_id', 'listeners', 'speakers'], 'required'],

            ['decree', 'string', 'max' => '324'],
            ['reception_group_id', 'integer'],

            ['listeners', 'each', 'rule' => ['integer']],
            ['speakers', 'each', 'rule' => ['integer']],

            [
                ['listeners', 'speakers'],
                'filter',
                'filter' => function (array $data) {
                    return array_unique($data);
                }
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'decree'             => \Yii::t('app', 'Decree'),
            'listeners'          => \Yii::t('app', 'Listened'),
            'reception_group_id' => \Yii::t('app', 'Group'),
            'speakers'           => \Yii::t('app', 'Speakers'),
        ];
    }
}