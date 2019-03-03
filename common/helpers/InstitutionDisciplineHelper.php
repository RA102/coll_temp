<?php

namespace common\helpers;

use common\models\organization\InstitutionDiscipline;
use Yii;

class InstitutionDisciplineHelper
{
    public static function getTypeList()
    {
        return [
            InstitutionDiscipline::TYPE_STANDARD => Yii::t('app', 'Discipline Type Standard'),
            InstitutionDiscipline::TYPE_OPTIONAL => Yii::t('app', 'Discipline Type Optional'),
            InstitutionDiscipline::TYPE_ELECTIVE => Yii::t('app', 'Discipline Type Elective'),
            InstitutionDiscipline::TYPE_ENT => Yii::t('app', 'Discipline Type ENT'),
            InstitutionDiscipline::TYPE_EXAM => Yii::t('app', 'Discipline Type Exam'),
        ];
    }
}
