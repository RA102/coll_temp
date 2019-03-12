<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\person\Student */
/* @var $form frontend\models\forms\PersonDocumentsForm */
/* @var $activeForm yii\widgets\ActiveForm */
?>

<?php $this->beginBlock('update-content') ?>

    <?php $activeForm = ActiveForm::begin(); ?>

    <legend class="text-semibold center-block">
        <?= 'Свидетельство о рождении'?>
    </legend>

    <div class="row">
        <div class="col-md-4">
            <?= $activeForm->field($form, 'birth_certificate_series')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $activeForm->field($form, 'birth_certificate_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $activeForm->field($form, 'birth_certificate_issued_date')->widget(DatePicker::class, [
                'language' => 'ru',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]); ?>
        </div>
    </div>

    <legend class="text-semibold center-block">
        <?= 'Удостоверение личности'?>
    </legend>

    <?= $activeForm->field($form, 'identity_card_number')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'identity_card_issued_date')->widget(DatePicker::class, [
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]); ?>

    <?= $activeForm->field($form, 'identity_card_valid_date')->widget(DatePicker::class, [
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]); ?>

    <?= $activeForm->field($form, 'identity_card_issued')->textInput(['maxlength' => true]) ?>

    <legend class="text-semibold center-block">
        <?= 'Паспорт'?>
    </legend>

    <?= $activeForm->field($form, 'passport_series')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'passport_number')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'passport_issued_date')->widget(DatePicker::class, [
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]); ?>

    <?= $activeForm->field($form, 'passport_valid_date')->widget(DatePicker::class, [
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]); ?>

    <?= $activeForm->field($form, 'passport_issued')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<?php $this->endBlock() ?>

<?= $this->render('_update_layout', ['model' => $model]) ?>
