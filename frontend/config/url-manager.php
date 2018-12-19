<?php

return [
    'class'           => 'yii\web\UrlManager',
    'baseUrl'         => '',
    'enablePrettyUrl' => true,
    'showScriptName'  => false,
    'rules'           => [
        'student' => '/student/index',
        'employee' => '/employee/index',
        '<a:\w+>' => 'site/<a>',
    ],
];
