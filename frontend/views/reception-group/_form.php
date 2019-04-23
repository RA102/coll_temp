<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReceptionGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reception-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'caption')->textInput() ?>

    <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'speciality_id')->textInput() ?>

    <?= $form->field($model, 'education_form')->textInput() ?>

    <?= $form->field($model, 'institution_id')->textInput() ?>

    <?= $form->field($model, 'budget_places')->textInput() ?>

    <?= $form->field($model, 'commercial_places')->textInput() ?>

    <?= $form->field($model, 'create_ts')->textInput() ?>

    <?= $form->field($model, 'update_ts')->textInput() ?>

    <?= $form->field($model, 'delete_ts')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
