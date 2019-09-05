<?php

namespace frontend\models\forms;

use common\models\link\CommissionMemberLink;
use Yii;
use yii\base\Model;

class AdmissionProtocolForm extends Model
{
    public $completion_date;
    public $number;
    public $commission_members;
    public $agendas;
    protected $commission_id;

    /**
     * AdmissionProtocolForm constructor.
     * @param array $config
     * @param int $commission_id
     */
    public function __construct(int $commission_id, array $config = [])
    {
        parent::__construct($config);

        $this->commission_id = $commission_id;
    }

    public function rules()
    {
        return [
            [['completion_date', 'number', 'commission_members', 'agendas'], 'required'],

            ['number', 'integer'],
            ['number', 'filter', 'filter' => 'strval'],

            //['completion_date', 'date', 'format' => 'php:Y-m-d'],

            ['commission_members', 'each', 'rule' => ['integer']],
            [
                'commission_members',
                'filter',
                'filter' => function (array $commission_members) {
                    return array_unique($commission_members);
                }
            ],
            [
                'commission_members',
                'each',
                'rule' => [
                    'exist',
                    'targetClass'     => CommissionMemberLink::class,
                    'targetAttribute' => 'member_id',
                    'filter'          => ['commission_id' => $this->commission_id]
                ]
            ],

            ['agendas', 'each', 'rule' => ['string', 'max' => 1024]],

        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'number'             => Yii::t('app', 'Number'),
            'completion_date'    => Yii::t('app', 'Date of filling'),
            'commission_members' => Yii::t('app', 'Commission members'),
            'agendas'            => Yii::t('app', 'Agenda')
        ];
    }

    /**
     * @return string
     */
    public function formName()
    {
        return "";
    }
}