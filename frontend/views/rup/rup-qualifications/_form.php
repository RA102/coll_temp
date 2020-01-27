<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupQualifications */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-qualifications-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'qualification_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time_years')->textInput() ?>

    <?= $form->field($model, 'time_months')->textInput() ?>

    <?= $form->field($model, 'qualification_code')->textInput() ?>

    <?= $form->field($model, 'rup_id')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success','id'=>'submitQualification']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
