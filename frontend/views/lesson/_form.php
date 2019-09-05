<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\organization\Group */
/* @var $form yii\widgets\ActiveForm */
/* @var $specialities \common\models\handbook\Speciality[] */
?>

<div class="lesson-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'weekday')->dropDownList(
		$weekdays,
		[]
	) ?>

    <?= $form->field($model, 'number')->dropDownList(
		['1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10'],
		[]
	) ?>

    <?= $form->field($model, 'teacher_course_id')->widget(Select2::class, [
        'data' => ArrayHelper::map($teacherCourses, 'id', 'fullname'), /** @see \common\models\TeacherCourse::getFullname() */
        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'teacher_id')->widget(Select2::class, [
        'data' => ArrayHelper::map($teachers, 'id', 'fullName'), // TODO rework to ajax
        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'classroom_id')->widget(Select2::class, [
        'data' => ArrayHelper::map($classrooms, 'id', 'number'), // TODO rework to ajax
        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'group_id')->hiddenInput(['value' => $group->id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
