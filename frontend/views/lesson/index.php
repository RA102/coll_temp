<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $teacherCourses common\models\TeacherCourse[] */
/* @var $teachers common\models\person\Employee[] */
/* @var $searchModel frontend\search\LessonSearch */

\frontend\assets\FullcalendarAsset::register($this);
$this->title = Yii::t('app', 'Lessons');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div style="position: relative;">
        <h1><?= $this->title ?></h1>
    </div>

    <div class="lesson-index skin-white">
        <div class="card-body">
            <div id="calendar" class="fc fc-unthemed fc-ltr"></div>
        </div>
    </div>

<?= $this->render('_create_form', [
    'model' => new \frontend\models\forms\LessonForm(),
    'teacherCourses' => $teacherCourses,
    'teachers' => $teachers,
]); ?>

<?php
$feedUrl = json_encode(Url::to(array_merge(['lesson/ajax-feed'], [Html::getInputName($searchModel, 'group_id') => $searchModel->group_id])));
$createUrl = json_encode(Url::to(['lesson/ajax-create']));
$deleteUrl = json_encode(Url::to(['lesson/ajax-delete']));

$this->registerJs("
var feedUrl = {$feedUrl};
var createUrl = {$createUrl};
var deleteUrl = {$deleteUrl};
", View::POS_BEGIN);
?>