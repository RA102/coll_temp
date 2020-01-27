<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\rup\RupRoots */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-roots-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rup_year')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'create_ts')->textInput() ?>

    <?= $form->field($model, 'delete_ts')->textInput() ?>

    <?= $form->field($model, 'lastopen_ts')->textInput() ?>

    <?= $form->field($model, 'lastclose_ts')->textInput() ?>

    <?= $form->field($model, 'create_userid')->textInput() ?>

    <?= $form->field($model, 'delete_userid')->textInput() ?>

    <?= $form->field($model, 'lastopen_userid')->textInput() ?>

    <?= $form->field($model, 'lastclose_userid')->textInput() ?>

    <?= $form->field($model, 'captionRu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'captionKz')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profile_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'spec_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edu_form')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
