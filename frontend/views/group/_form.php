<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\organization\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'caption_ru')->textInput() ?>

    <?= $form->field($model, 'caption_kk')->textInput() ?>

    <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'speciality_id')->textInput() ?>

    <?= $form->field($model, 'max_class')->textInput() ?>

    <?= $form->field($model, 'class')->textInput() ?>

    <?= $form->field($model, 'education_form')->dropDownList(\common\helpers\GroupHelper::getEducationFormList()) ?>

    <?= $form->field($model, 'education_pay_form')->dropDownList(\common\helpers\GroupHelper::getEducationPayFormList()) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
