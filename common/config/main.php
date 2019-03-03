<?php
$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'language' => 'kz-KZ',
    'sourceLanguage' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap'  => [
                        'app'       => 'app.php',
                        'app/error' => 'error.php'
                    ]
                ],
            ],
        ],
    ],
    'container' => [
        'singletons' => [
            'common\gateways\bilimal\BilimalNotificationsGateway' => [
                'accessToken' => $params['bilimal_notifications_access_token']
            ],
            'common\gateways\pds\PdsGateway'                      => [
                'accessToken' => $params['pds_access_token'],
                'baseUrl'     => $params['pds_url']
            ],
        ]
    ]
];
