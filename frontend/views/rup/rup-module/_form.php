<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupModule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-module-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'create')->textInput() ?>

    <?= $form->field($model, 'update_ts')->textInput() ?>

    <?= $form->field($model, 'caption_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'caption_kz')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profession_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'study_form')->textInput() ?>

    <?= $form->field($model, 'profile_id')->textInput() ?>

    <?= $form->field($model, 'spec_id')->textInput() ?>

    <?= $form->field($model, 'level_id')->textInput() ?>

    <?= $form->field($model, 'study_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
