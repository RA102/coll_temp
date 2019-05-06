<?php

namespace frontend\models\forms;

use common\helpers\ApplicationHelper;
use common\models\organization\Group;
use common\models\reception\AdmissionApplication;
use yii\base\Model;
use yii\db\ActiveQuery;

class EnlistEntrantForm extends Model
{
    public $admission_application_id;
    public $group_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['admission_application_id', 'group_id'], 'required'],
            [['admission_application_id', 'group_id'], 'integer'],
            [
                'admission_application_id',
                'exist',
                'targetClass'     => AdmissionApplication::class,
                'targetAttribute' => 'id',
                'filter'          => function (ActiveQuery $queryBuilder) {
                    return $queryBuilder->andWhere(['status' => ApplicationHelper::STATUS_ACCEPTED]);
                }
            ],
            [
                'group_id',
                'exist',
                'targetClass'     => Group::class,
                'targetAttribute' => 'id'
            ]
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


