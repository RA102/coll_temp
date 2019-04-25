<?php

use common\helpers\PersonHelper;
use common\helpers\PersonTypeHelper;
use common\models\Nationality;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use common\components\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\person\Person */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-form">
    <?php
    Pjax::begin([
        'id' => 'list-pjax',
        'formSelector' => '#js-update',
        'scrollTo' => 'false',
    ]);
    ?>

    <?php $form = ActiveForm::begin([
        'id' => 'js-update',
        'enableClientValidation' => false,
        'options' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <fieldset>
                <legend>ДАННЫЕ ПОЛЬЗОВАТЕЛЯ</legend>

                <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'iin')
                    ->textInput(['maxlength' => true])
                    ->widget(\yii\widgets\MaskedInput::class, ['mask' => '999999999999']) ?>

                <?= $form->field($model, 'birth_date')->widget(DatePicker::class, [
                    'language' => 'ru',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]) ?>

                <?= $form->field($model, 'sex')->widget(Select2::class, [
                    'data' => PersonHelper::getSexList(),
                    'options' => ['placeholder' => ''],
                    'theme' => 'default',
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>

                <?= $form->field($model, 'nationality_id')->widget(Select2::class, [
                    'data' => \yii\helpers\ArrayHelper::map(Nationality::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => ''],
                    'theme' => 'default',
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset>
                <legend>ДОПОЛНИТЕЛЬНО</legend>

                <?= $form->field($model, 'status')->widget(Select2::class, [
                    'data' => PersonHelper::getStatusList(),
                    'options' => ['placeholder' => ''],
                    'theme' => 'default',
                ]) ?>

                <?= $form->field($model, 'type')->textInput() ?>

                <?= $form->field($model, 'person_type')->widget(Select2::class, [
                    'data' => PersonTypeHelper::getList(),
                    'options' => ['placeholder' => ''],
                    'theme' => 'default',
                ]) ?>
            </fieldset>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Назад'), ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>
