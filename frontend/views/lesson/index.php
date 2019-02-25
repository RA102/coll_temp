<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel frontend\search\LessonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $teacherCourses common\models\TeacherCourse[] */

\frontend\assets\FullcalendarAsset::register($this);
$this->title = Yii::t('app', 'Lessons');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div style="position: relative;">
        <h1><?= $this->title ?></h1>
        <?= Html::a('Добавить', ['create'], ['class' => 'title-action btn btn-primary']) ?>
    </div>

    <div class="lesson-index skin-white">
        <div class="card-body">
            <div id="calendar" class="fc fc-unthemed fc-ltr"></div>
        </div>
    </div>

<?= $this->render('_create_form', [
    'model' => new \frontend\models\forms\LessonForm(),
    'teacherCourses' => $teacherCourses,
]); ?>

<?php
$feedUrl = json_encode(Url::to(array_merge(['lesson/ajax-feed'], \Yii::$app->request->getQueryParams())));
$createUrl = json_encode(Url::to(['lesson/ajax-create']));
$updateUrl = json_encode(Url::to(['lesson/ajax-update']));
$deleteUrl = json_encode(Url::to(['lesson/ajax-delete']));

$this->registerJs("
var feedUrl = {$feedUrl};
var createUrl = {$createUrl};
var updateUrl = {$updateUrl};
var deleteUrl = {$deleteUrl};
", View::POS_BEGIN);
?>
