<?php

namespace common\helpers;

use common\models\Discipline;
use common\models\reception\Commission;
use Yii;

/**
 * Class CommissionHelper
 * @package common\helpers
 */
class CommissionHelper
{
    public static function getStatusList()
    {
        return [
            Commission::STATUS_ACTIVE => Yii::t('app', 'Commission Status Active'),
            Commission::STATUS_CLOSED => Yii::t('app', 'Commission Status Closed'),
        ];
    }
}
