<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form frontend\models\forms\CommissionForm */
/* @var $institutionDisciplines common\models\organization\InstitutionDiscipline[] */
/* @var $activeForm yii\widgets\ActiveForm */
?>

<div class="commission-form">

    <?php $activeForm = ActiveForm::begin(); ?>

    <h4>Название и сроки проведения комиссии</h4>

    <?= $activeForm->field($form, 'caption_ru')->textInput() ?>

    <?= $activeForm->field($form, 'caption_kk')->textInput() ?>

    <?= $activeForm->field($form, 'from_date')->widget(\kartik\date\DatePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>
    <?= $activeForm->field($form, 'to_date')->widget(\kartik\date\DatePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <hr>

    <h4>Номер и дата создания приказа, на основании которого создается комиссия</h4>

    <?= $activeForm->field($form, 'order_number')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'order_date')->widget(\kartik\date\DatePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <hr>

    <h4>Экзамены</h4>

    <?= $activeForm->field($form, 'exam_start_date')->widget(\kartik\date\DatePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <?= $activeForm->field($form, 'exam_end_date')->widget(\kartik\date\DatePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <hr>

    <h4>Квалификации</h4>

    <?= $activeForm->field($form, 'institution_discipline_ids')->widget(\kartik\select2\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map($institutionDisciplines, 'id', 'caption_current'),
        'options' => [
            'placeholder' => '...',
            'class' => 'active-form-refresh-control',
            'multiple' => true,
        ],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
