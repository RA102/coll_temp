<?php

return [
    'class' => 'yii\web\UrlManager',
    'baseUrl' => '',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        'OPTIONS,GET v1/groups' => 'v1/site/groups',
        'OPTIONS,GET v1/groups/<group_id>/students' => 'v1/site/students',
        'OPTIONS,GET v1/courses' => 'v1/site/courses',
        'OPTIONS,GET v1/courses/<course_id>/teacher-courses/<teacher_course_id>/lessons' => 'v1/site/lessons',
        'OPTIONS,POST v1/students/<student_id>/grades' => '/v1/site/post-grade',
    ],
];
