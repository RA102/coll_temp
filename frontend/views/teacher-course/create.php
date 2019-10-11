<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TeacherCourse */
/* @var $course common\models\Course */
/* @var $teachers common\models\person\Employee[] */
/* @var $groups common\models\organization\Group[] */

$this->title = Yii::t('app', 'Create Teacher Course');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['course/index']];
$this->params['breadcrumbs'][] = ['label' => $course->caption_current, 'url' => ['course/view', 'id' => $course->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
<div class="teacher-course-create">

    <?= $this->render('_form', [
        'model' => $model,
        'teachers' => $teachers,
        'groups' => $groups,
        'types' => $types,
        'statuses' => $statuses,
    ]) ?>

</div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>
