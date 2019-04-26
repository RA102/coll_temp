<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReceptionExam */
/* @var $form yii\widgets\ActiveForm */
/* @var $teachers common\models\person\Employee[] */
/* @var $institutionDisciplines common\models\organization\InstitutionDiscipline[] */
/* @var $receptionGroups common\models\ReceptionGroup[] */
?>

<div class="reception-exam-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'teacher_id')->widget(\kartik\select2\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map($teachers, 'id', 'fullName'), /** @see Employee::getFullName() */ // TODO rework to ajax
        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'institution_discipline_id')->widget(\kartik\select2\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map($institutionDisciplines, 'id', 'caption_current'), /** @see InstitutionDiscipline::$caption_current() */
        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'group_ids')->widget(\kartik\select2\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map($receptionGroups, 'id', 'caption_current'), /** @see Group::$caption_current */
        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'date')->widget(\kartik\date\DatePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <?= $form->field($model, 'time')->dropDownList((function () {
            $result = [];
            for ($i = 8; $i <= 20; $i++) {
                $time = str_pad($i, 2, 0, STR_PAD_LEFT) . ':00';
                $result[$time] = $time;
            }
            return $result;
    })()) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
