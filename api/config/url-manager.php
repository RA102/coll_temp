<?php

return [
    'class' => 'yii\web\UrlManager',
    'baseUrl' => '',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        'OPTIONS,GET v1/groups' => 'v1/site/groups',
        'OPTIONS,GET v1/groups/<group_id>/students' => 'v1/site/students',
    ],
];
