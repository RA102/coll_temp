<?php

namespace common\models\person;

use Yii;

class PersonHelper
{
    public function getSexList()
    {
        return [
            Person::SEX_NONE => Yii::t('app', 'Sex None'),
            Person::SEX_MALE => Yii::t('app', 'Sex Male'),
            Person::SEX_FEMALE => Yii::t('app', 'Sex Female'),
        ];
    }
}
