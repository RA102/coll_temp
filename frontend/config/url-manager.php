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
        'reception-group/<commission_id:\d+>'                                                                                                            => '/reception-group/index',
        'reception-group/entrants/<reception_group_id:\d+>'                                                                                              => '/reception-group/entrants',
        'reception-exam/<commission_id:\d+>'                                                                                                             => '/reception-exam/index',
        'appeal-commission/view/<id:\d+>'                                                                                                                => '/appeal-commission/view',
        'appeal-commission/create/<id:\d+>'                                                                                                              => '/appeal-commission/create',
        'appeal-commission-member/<commission_id:\d+>'                                                                                                   => '/appeal-commission-member/index',
        'appeal-commission-member/create/<id:\d+>'                                                                                                       => '/appeal-commission-member/create',
        'appeal-application/<commission_id:\d+>'                                                                                                                    => '/appeal-application/index',
        'competition/<commission_id:\d+>'                                                                                                                => '/competition/index',
        'competition/view/<commission_id:\d+>/<speciality_id:\d+>/<education_pay_form:\d+>/<language:[a-z]{2}>/<education_form:\d+>/<based_classes:\d+>' => '/competition/view',
        'reception/entrance-exam-order/<commission_id:\d+>'=> 'reception/entrance-exam-order/index',
        '<a:\w+>'                                                                                                                                        => 'site/<a>',

        'POST pds/set-access-token' => 'api/pds/set-access-token',
        'GET pds/get-roles' => 'api/pds/get-roles',
        'GET pds/get-routes' => 'api/pds/get-routes'
    ],
];
