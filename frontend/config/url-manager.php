<?php

return [
    'class'           => 'yii\web\UrlManager',
    'baseUrl'         => '',
    'enablePrettyUrl' => true,
    'showScriptName'  => false,
    'rules'           => [
        'student' => '/student/index',
        'employee' => '/employee/index',
        'speciality' => '/speciality/index',
        'group' => '/group/index',
        'institution' => '/institution/index',
        'commission' => '/commission/index',
        'commission-member/<commission_id:\d+>' => '/commission-member/index',
        'reception-group/<commission_id:\d+>' => '/reception-group/index',
        'reception-exam/<commission_id:\d+>' => '/reception-exam/index',
        'appeal-commission/view/<id:\d+>' => '/appeal-commission/view',
        'appeal-commission/create/<id:\d+>' => '/appeal-commission/create',
        '<a:\w+>' => 'site/<a>',

        'POST pds/set-access-token' => 'api/pds/set-access-token',
        'GET pds/get-roles' => 'api/pds/get-roles',
        'GET pds/get-routes' => 'api/pds/get-routes'
    ],
];
