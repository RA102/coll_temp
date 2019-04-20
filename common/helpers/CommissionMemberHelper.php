<?php

namespace common\helpers;

use common\models\CommissionMemberLink;
use Yii;

/**
 * Class CommissionMemberHelper
 * @package common\helpers
 */
class CommissionMemberHelper
{
    public static function getRoleList()
    {
        return [
            CommissionMemberLink::ROLE_COMMISSION_MEMBER => Yii::t('app', 'Commission member'),
            CommissionMemberLink::ROLE_COMMISSION_SECRETARY => Yii::t('app', 'Commission secretary'),
            CommissionMemberLink::ROLE_COMMISSION_DEPUTY_CHAIRMAN => Yii::t('app', 'Commission deputy chairman'),
            CommissionMemberLink::ROLE_COMMISSION_CHAIRMAN => Yii::t('app', 'Commission chairman'),
        ];
    }
}