<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TeacherCourse */
/* @var $teachers common\models\person\Employee[] */

$this->title = Yii::t('app', 'Create Teacher Course');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
<div class="teacher-course-create">

    <?= $this->render('_form', [
        'model' => $model,
        'teachers' => $teachers,
    ]) ?>

</div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>
