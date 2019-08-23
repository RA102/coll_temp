<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TeacherCourse */
/* @var $course common\models\Course */
/* @var $teachers common\models\person\Employee[] */
/* @var $groups common\models\organization\Group[] */

$this->title = 'Продублировать занятие';
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
<div class="teacher-course-create">

    <?= $this->render('_lesson_copy_form', [
        'model' => $model,
        'teacherCourse' => $teacherCourse,
        'weeks' => $weeks,
    ]) ?>

</div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>
