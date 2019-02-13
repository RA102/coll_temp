<?php

namespace common\helpers;

use common\models\organization\Group;

class GroupHelper
{
    public static function getEducationFormList()
    {
        return [
            Group::EDUCATION_FORM_FULL_TIME => \Yii::t('app', 'Full time'),
            Group::EDUCATION_FORM_CORRESPONDENCE => \Yii::t('app', 'Correspondence'),
            Group::EDUCATION_FORM_EVENING => \Yii::t('app', 'Evening')
        ];
    }

    public static function getEducationPayFormList()
    {
        return [
            Group::EDUCATION_PAY_FORM_BUDGET => \Yii::t('app', 'Budget'),
            Group::EDUCATION_PAY_FORM_CONTRACT => \Yii::t('app', 'Contract'),
            Group::EDUCATION_PAY_FORM_MIXED => \Yii::t('app', 'Mixed')
        ];
    }
}
