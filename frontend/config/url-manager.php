<?php

return [
    'class'           => 'yii\web\UrlManager',
    'baseUrl'         => '',
    'enablePrettyUrl' => true,
    'showScriptName'  => false,
    'rules'           => [
        '<a:\w+>' => 'site/<a>'
    ],
];
