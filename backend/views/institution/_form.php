<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\organization\Institution */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="institution-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'educational_form_id')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'type_id')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'max_shift')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'languages_iso')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'organizational_legal_form_id')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'enable_fraction')->checkbox() ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'min_grade')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'max_grade')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'foundation_year')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'bin')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'country_id')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'city_id')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'street_id')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'house_number')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'status')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
