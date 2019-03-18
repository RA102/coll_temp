<?php

namespace common\helpers;

use common\models\organization\InstitutionApplication;

class InstitutionApplicationHelper
{
    public static function getStatusList()
    {
        return [
            InstitutionApplication::STATUS_NEW => 'Новый',
            InstitutionApplication::STATUS_APPROVED => 'Одобрен',
            InstitutionApplication::STATUS_REJECTED => 'Отклонен',
        ];
    }
}