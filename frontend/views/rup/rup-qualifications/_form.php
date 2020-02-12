<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupQualifications */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-qualifications-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'qualification_name')->textInput(['maxlength' => true])->label('Квалификация') ?>

    <?= $form->field($model, 'q_level')->textInput(['maxlength' => true])->label('Уровень') ?>

    <?= $form->field($model, 'qualification_code')->textInput()->label('Код специальности') ?>

    <?= $form->field($model, 'time_years')->textInput()->label('Количество лет') ?>

    <?= $form->field($model, 'time_months')->textInput()->label('Количество месяцев') ?>

    <?= $form->field($model, 'rup_id')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary','id'=>'submitQualification']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
