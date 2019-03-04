<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\forms\TeacherCourseForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $teachers common\models\person\Employee[] */
/* @var $groups common\models\organization\Group[] */

?>

<div class="teacher-course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'teacher_id')->widget(Select2::class, [
        'data' => ArrayHelper::map($teachers, 'id', 'fullName'), /** @see Employee::getFullName() */ // TODO rework to ajax
        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'group_ids')->widget(Select2::class, [
        'data' => ArrayHelper::map($groups, 'id', 'caption_current'), /** @see Group::$caption_current */ // TODO rework to ajax
        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_ts')->widget(DatePicker::class, [
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]); ?>

    <?= $form->field($model, 'end_ts')->widget(DatePicker::class, [
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
