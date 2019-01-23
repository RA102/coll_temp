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

        'POST pds/set-access-token' => 'api/pds/set-access-token',
        'GET pds/get-roles' => 'api/pds/get-roles',
        'GET pds/get-routes' => 'api/pds/get-routes'
    ],
];
