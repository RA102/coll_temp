<?php

namespace common\helpers;

use common\models\person\Person;
use Yii;

class PersonHelper
{
    public function getTypeList()
    {
        return [
            Person::TYPE_UNDEFINED => Yii::t('app', 'PersonType Undefined'),
            Person::TYPE_STUDENT => Yii::t('app', 'PersonType Student'),
            Person::TYPE_EMPLOYEE => Yii::t('app', 'PersonType Employee'),
        ];
    }

    public function getSexList()
    {
        return [
            Person::SEX_NONE => Yii::t('app', 'Sex None'),
            Person::SEX_MALE => Yii::t('app', 'Sex Male'),
            Person::SEX_FEMALE => Yii::t('app', 'Sex Female'),
        ];
    }
}
