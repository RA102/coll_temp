<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealApplication */
/* @var $form yii\widgets\ActiveForm */
/* @var $entrants \common\models\person\Entrant[] */
$teacherCourses = ArrayHelper::map($teacherCourses, 'id', 'disciplineName');
$groups = ArrayHelper::map($groups, 'id', 'caption_current');
?>

<div class="appeal-application-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'teacher_course_id')->widget(Select2::class, [
        'data' => $teacherCourses, // TODO rework to ajax
        'options' => ['placeholder' => 'Выберите дисциплину', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?> -->

    <?= $form->field($model, 'caption_kk')->textInput()->label('Название на казахском') ?>

    <?= $form->field($model, 'caption_ru')->textInput()->label('Название на русском') ?>

    <?= $form->field($model, 'group_id')->widget(Select2::class, [
        'data' => $groups, // TODO rework to ajax
        'options' => ['placeholder' => 'Выберите группу', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <div class="row">
        <div class="col-md-4">

            <p>I семестр</p>

            <?= $form->field($model, 'hours[1]')->textInput() ?>

		    <?= $form->field($model, 'teacher[1]')->widget(Select2::class, [
		        'data' => ArrayHelper::map($teachers, 'id', 'fullName'), /** @see Employee::getFullName() */ // TODO rework to ajax
		        'options' => ['placeholder' => 'Выберите преподавателя', 'class' => 'active-form-refresh-control'],
		        'theme' => 'default',
		        'pluginOptions' => [
		            'allowClear' => true,
		        ],
		    ])->label('Преподаватель') ?>

        </div>

        <div class="col-md-4">

            <p>II семестр</p>

            <?= $form->field($model, 'hours[2]')->textInput() ?>

		    <?= $form->field($model, 'teacher[2]')->widget(Select2::class, [
		        'data' => ArrayHelper::map($teachers, 'id', 'fullName'), /** @see Employee::getFullName() */ // TODO rework to ajax
		        'options' => ['placeholder' => 'Выберите преподавателя', 'class' => 'active-form-refresh-control'],
		        'theme' => 'default',
		        'pluginOptions' => [
		            'allowClear' => true,
		        ],
		    ])->label('Преподаватель') ?>
            
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
