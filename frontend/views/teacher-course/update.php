<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TeacherCourse */
/* @var $teachers common\models\person\Employee[] */

$this->title = Yii::t('app', 'Update Teacher Course') . ': ' . $model->course->caption_current;
$this->params['breadcrumbs'][] = ['label' => $model->course->caption_current, 'url' => ['view', 'id' => $model->id, 'course_id' => $model->course_id]];
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