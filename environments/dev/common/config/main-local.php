<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=preview;dbname=db_beta_college',
            'username' => 'betabilimal',
            'password' => 'B1t3fahrenvu',
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
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
