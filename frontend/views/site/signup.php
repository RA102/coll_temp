<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use common\helpers\PersonHelper;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="app flex-row align-items-center">
    <div class="container">
        <div class="site-signup mt-4">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card mx-4 mt-4">
                        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                        <div class="card-body p-4">
                            <h1>Регистрация</h1>
                            <p class="text-muted">Оформить заявку на регистрацию в системе «Бiлiмал».</p>

                            <fieldset>
                                <legend>Организация</legend>
                                <?= $form->field($model, 'educational_form_id') ?>
                                <?= $form->field($model, 'organizational_legal_form_id') ?>
                                <?= $form->field($model, 'name') ?>
                                <?= $form->field($model, 'city_id') ?>
                                <?= $form->field($model, 'street') ?>
                                <?= $form->field($model, 'house_number') ?>
                            </fieldset>

                            <fieldset>
                                <legend>Администратор/Директор</legend>
                                <?= $form->field($model, 'lastname') ?>
                                <?= $form->field($model, 'firstname') ?>
                                <?= $form->field($model, 'middlename') ?>
                                <?= $form->field($model, 'iin')
                                    ->textInput(['maxlength' => true])
                                    ->widget(\yii\widgets\MaskedInput::class, ['mask' => '999999999999'])
                                ?>
                                <?= $form->field($model, 'birth_date')->widget(DatePicker::class, [
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ]); ?>
                                <?= $form->field($model, 'sex')->dropDownList(PersonHelper::getSexList()) ?>
                                <?= $form->field($model, 'email') ?>
                                <?= $form->field($model, 'phone')
                                    ->textInput()
                                    ->widget(\yii\widgets\MaskedInput::class, ['mask' => '+7 (999) 999-99-99',]) ?>
                            </fieldset>

                        </div>
                        <div class="card-footer p-4">
                            <?= Html::submitButton(
                                Yii::t('app', 'Create'),
                                ['class' => 'btn btn-success btn-block','name' => 'signup-button']
                            ) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>