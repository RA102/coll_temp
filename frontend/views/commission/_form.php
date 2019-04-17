<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\reception\Commission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="commission-form">

    <?php $form = ActiveForm::begin(); ?>

    <h4>Название и сроки проведения комиссии</h4>

    <?= $form->field($model, 'caption_ru')->textInput() ?>

    <?= $form->field($model, 'caption_kk')->textInput() ?>

    <?= $form->field($model, 'from_date')->widget(\kartik\date\DatePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>
    <?= $form->field($model, 'to_date')->widget(\kartik\date\DatePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <hr>

    <h4>Номер и дата создания приказа, на основании которого создается комиссия</h4>

    <?= $form->field($model, 'order_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_date')->widget(\kartik\date\DatePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <hr>

    <h4>Экзамены</h4>

    <?= $form->field($model, 'exam_start_date')->widget(\kartik\date\DatePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <?= $form->field($model, 'exam_end_date')->widget(\kartik\date\DatePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
