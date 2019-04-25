<?php

namespace common\helpers;

use common\models\Discipline;
use common\models\organization\Institution;
use Yii;

class InstitutionHelper
{
    public static function getStatusList()
    {
        return [
            Institution::STATUS_ACTIVE => 'Активен',
            Institution::STATUS_DISABLED => 'Отключен'
        ];
    }

    public static function getList()
    {
        /* @var $models Institution[] */
        $models = Institution::find()->all();
        $result = [];
        foreach ($models as $model) {
            $result[$model->id] = $model->name;
        }

        return $result;
    }
}
