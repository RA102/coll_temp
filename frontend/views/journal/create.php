<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\organization\Group */
/* @var $specialities \common\models\handbook\Speciality[] */

$this->title = Yii::t('app', 'Create Journal');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Journals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
<div class="journal-create">

    <?= $this->render('_form', [
        'model' => $model,
        'teacherCourses' => $teacherCourses,
        'teachers' => $teachers,
        'types' => $types
    ]) ?>

</div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>
