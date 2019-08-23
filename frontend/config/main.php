<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'Бiлiмал. Электронды колледж',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone' => 'Asia/Almaty',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\person\Person',
            'enableAutoLogin' => true,
            'loginUrl' => '/site/login',
            'absoluteAuthTimeout' => 3600 * 12,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => '3qJKDhkKxunv3ztKTUxBj7ddL6G2uLLPu7MPffnjBFXNEzaEebB4AeJTJwUBm8U4',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
//                [
//                    'class'  => 'common\components\SentryTarget',
//                    'dsn'    => $params['sentry_dsn'],
//                    'levels' => ['error'],
//                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => require __DIR__ . '/url-manager.php',
    ],
    'params' => $params,
];
