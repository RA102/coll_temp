<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Course */
/* @var $disciplines common\models\Discipline[] */
/* @var $classes array */

$this->title = Yii::t('app', 'Update Course') . ': ' . $model->discipline->caption_current;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->discipline->caption_current, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
    <div class="course-update">

        <?= $this->render('_form', [
            'model' => $model,
            'disciplines' => $disciplines,
            'classes' => $classes,
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>
