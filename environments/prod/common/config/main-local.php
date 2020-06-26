<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=pg3.vpn;dbname=db_college_general',
            'username' => 'bilimal',
            'password' => 'p97356y20734f',
            'charset' => 'utf8',
        ],
        'gospdb' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=pg3.vpn;dbname=db_gosin',
            'username' => 'gosin',
            'password' => 'g0s1ntowa4',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
