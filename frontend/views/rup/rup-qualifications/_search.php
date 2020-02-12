<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupQualificationsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-qualifications-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'qualification_name') ?>

    <?= $form->field($model, 'time_years') ?>

    <?= $form->field($model, 'time_months') ?>

    <?= $form->field($model, 'rup_id') ?>

    <?php // echo $form->field($model, 'qualification_code') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
