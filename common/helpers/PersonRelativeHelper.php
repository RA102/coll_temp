<?php

namespace common\helpers;

use common\models\PersonRelative;
use Yii;

class PersonRelativeHelper
{
    public static function getRelationTypeList()
    {
        return [
            PersonRelative::RELATION_TYPE_FATHER => Yii::t('app', 'Father'),
            PersonRelative::RELATION_TYPE_MOTHER => Yii::t('app', 'Mother'),
            PersonRelative::RELATION_TYPE_FATHER_GUARDIAN => Yii::t('app', 'Father guardian'),
            PersonRelative::RELATION_TYPE_MOTHER_GUARDIAN => Yii::t('app', 'Mother guardian'),
            PersonRelative::RELATION_TYPE_JUST_GUARDIAN => Yii::t('app', 'Just guardian'),
            PersonRelative::RELATION_TYPE_HUSBAND => Yii::t('app', 'Husband'),
            PersonRelative::RELATION_TYPE_WIFE => Yii::t('app', 'Wife'),
            PersonRelative::RELATION_TYPE_SON => Yii::t('app', 'Son'),
            PersonRelative::RELATION_TYPE_DAUGHTER => Yii::t('app', 'Daughter'),
            PersonRelative::RELATION_TYPE_BROTHER => Yii::t('app', 'Brother'),
            PersonRelative::RELATION_TYPE_SISTER => Yii::t('app', 'Sister'),
        ];
    }
}
