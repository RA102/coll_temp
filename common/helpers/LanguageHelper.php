<?php

namespace common\helpers;

class LanguageHelper
{
    public static function getLanguageList()
    {
        return [
            'ru' => \Yii::t('app', 'Russian'),
            'kk' => \Yii::t('app', 'Kazakh'),
            //'kz' => \Yii::t('app', 'Kazakh'),
        ];
    }
}
