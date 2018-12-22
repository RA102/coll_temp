<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use common\helpers\PersonHelper;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionApplication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="institution-application-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <legend>ДАННЫЕ ОРГАНИЗАЦИИ</legend>
            <div class="col-md-12">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'organizational_legal_form_id')->textInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'educational_form_id')->textInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'type_id')->textInput() ?>
            </div>

            <div class="col-md-12">
                <legend>АДРЕСНЫЕ ДАННЫЕ</legend>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'city_id')->textInput() ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'house_number')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <legend>КОНТАКТНЫЕ ДАННЫЕ</legend>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'phone')
                            ->textInput()
                            ->widget(\yii\widgets\MaskedInput::class, ['mask' => '+7 (999) 999-99-99',]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <legend>ДАННЫЕ ПОЛЬЗОВАТЕЛЯ</legend>
            <div class="col-md-12">
                <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'iin')
                    ->textInput(['maxlength' => true])
                    ->widget(\yii\widgets\MaskedInput::class, ['mask' => '999999999999'])
                ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'birth_date')->widget(DatePicker::class, [
                    'language' => 'ru',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]); ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'sex')->dropDownList(PersonHelper::getSexList()) ?>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-12">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
