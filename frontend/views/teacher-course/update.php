<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TeacherCourse */
/* @var $course common\models\Course */
/* @var $teachers common\models\person\Employee[] */

$this->title = Yii::t('app', 'Update Teacher Course') . ': ' . $model->course->caption_current;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['course/index']];
$this->params['breadcrumbs'][] = ['label' => $model->course->caption_current, 'url' => ['course/view', 'id' => $model->course->id]];
$this->params['breadcrumbs'][] = ['label' => $model->getFullname(), 'url' => ['view', 'id' => $model->id, 'course_id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
<div class="teacher-course-update">

    <?= $this->render('_form', [
        'model' => $model,
        'teachers' => $teachers,
    ]) ?>

</div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>