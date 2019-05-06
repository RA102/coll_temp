<?php

namespace common\helpers;

use common\models\Discipline;
use common\models\reception\AppealApplication;
use common\models\reception\Commission;
use Yii;

/**
 * Class AppealApplicationHelper
 * @package common\helpers
 */
class AppealApplicationHelper
{
    public static function getStatusList()
    {
        return [
            AppealApplication::STATUS_NEW => Yii::t('app', 'Appeal new'),
            AppealApplication::STATUS_ACCEPTED => Yii::t('app', 'Appeal accepted'),
            AppealApplication::STATUS_REJECTED => Yii::t('app', 'Appeal rejected'),
        ];
    }
}
