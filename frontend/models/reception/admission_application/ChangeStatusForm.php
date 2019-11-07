<?php

namespace frontend\models\reception\admission_application;

use common\helpers\ApplicationHelper;
use Yii;
use yii\base\Model;

class ChangeStatusForm extends Model
{
    public $status;
    public $reception_group_id;
    public $reason;
    protected $currentStatus = ApplicationHelper::STATUS_CREATED;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['reception_group_id', 'reason'], 'default', 'value' => null],

            ['status', 'required'],
            
            [
                'status', 
                'integer', 
                'min' => $this->currentStatus,
                'when'                   => function () {
                    return !\Yii::$app->user->identity->isSuperadmin();
                },
                'enableClientValidation' => false,
            ],

            ['status', 'in', 'range' => array_keys(ApplicationHelper::getAdmissionApplicationStatusLabels())],

            [
                'reception_group_id',
                'required',
                'when'                   => function () {
                    return $this->status == ApplicationHelper::STATUS_ACCEPTED;
                },
                'enableClientValidation' => false
            ],
            [
                'reception_group_id',
                'integer'
            ],

            [
                'reason',
                'required',
                'when'                   => function () {
                    return in_array(
                        $this->status,
                        [ApplicationHelper::STATUS_DECLINED, ApplicationHelper::STATUS_WITHDRAWN]
                    );
                },
                'enableClientValidation' => false
            ],
            [
                'reason',
                'string'
            ]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'status'             => Yii::t('app', 'Status'),
            'reception_group_id' => Yii::t('app', 'Group'),
            'reason'             => Yii::t('app', 'Причина'),
        ];
    }

    /**
     * @param int $status
     */
    public function setCurrentStatus(int $status)
    {
        $this->currentStatus = $status;
        if (!$this->status) {
            $this->status = $status;
        }
    }
}