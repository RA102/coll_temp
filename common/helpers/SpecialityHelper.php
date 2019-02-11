<?php

namespace common\helpers;

use common\models\handbook\Speciality;

class  SpecialityHelper {
    public static function getInstitutionTypes()
    {
        return [
            Speciality::INSTITUTION_TYPE_SPECIALIZED_SECONDARY => \Yii::t('app', 'Specialized secondary'),
            Speciality::INSTITUTION_TYPE_HIGHER => \Yii::t('app', 'Higher')
        ];
    }
}