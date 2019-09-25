<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TeacherCourse */
/* @var $teacherCourse common\models\TeacherCourse */
/* @var $course common\models\Course */
/* @var $teachers common\models\person\Employee[] */
/* @var $groups common\models\organization\Group[] */

$this->title = Yii::t('app', 'Update Teacher Course') . ': ' . $teacherCourse->course->caption_current;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['course/index']];
$this->params['breadcrumbs'][] = ['label' => $teacherCourse->course->caption_current, 'url' => ['course/view', 'id' => $teacherCourse->course->id]];
$this->params['breadcrumbs'][] = ['label' => $teacherCourse->getFullname(), 'url' => ['view', 'id' => $teacherCourse->id, 'course_id' => $teacherCourse->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
<div class="teacher-course-update">

    <?= $this->render('_form', [
        'model' => $model,
        'teachers' => $teachers,
        'groups' => $groups,
        'types' => $types,
    ]) ?>

</div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>