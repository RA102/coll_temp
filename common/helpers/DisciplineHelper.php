<?php

namespace common\helpers;

use common\models\Discipline;
use Yii;

class DisciplineHelper
{
    public static function getTypeList()
    {
        return [
            Discipline::TYPE_STANDARD => Yii::t('app', 'Discipline Type Standard'),
            Discipline::TYPE_OPTIONAL => Yii::t('app', 'Discipline Type Optional'),
            Discipline::TYPE_ELECTIVE => Yii::t('app', 'Discipline Type Elective'),
            Discipline::TYPE_ENT => Yii::t('app', 'Discipline Type ENT'),
            Discipline::TYPE_EXAM => Yii::t('app', 'Discipline Type Exam'),
        ];
    }
}
