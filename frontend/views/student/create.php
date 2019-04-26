<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\forms\StudentGeneralForm */

$this->title = Yii::t('app', 'Create Student');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?=$this->title?></h1>
<?php $this->beginBlock('content') ?>
    <div class="student-create">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>
