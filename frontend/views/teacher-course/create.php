<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TeacherCourse */

$this->title = Yii::t('app', 'Create Teacher Course');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teacher Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-course-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
