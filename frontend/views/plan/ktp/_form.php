<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealApplication */
/* @var $form yii\widgets\ActiveForm */
/* @var $entrants \common\models\person\Entrant[] */
?>

<div class="appeal-application-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

		    <?= $form->field($model, 'group_id')->widget(Select2::class, [
                'data' => ArrayHelper::map($groups, 'id', 'caption_current'), /** @see Employee::getFullName() */ // TODO rework to ajax
                'options' => ['placeholder' => 'Выберите группу', 'class' => 'active-form-refresh-control'],
                'theme' => 'default',
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>

            <?= $form->field($model, 'institution_discipline_id')->widget(Select2::class, [
                'data' => ArrayHelper::map($institutionDisciplines, 'id', 'caption_current'), /** @see Employee::getFullName() */ // TODO rework to ajax
                'options' => ['placeholder' => 'Выберите дисциплину', 'class' => 'active-form-refresh-control'],
                'theme' => 'default',
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>

            <?= $form->field($model, 'teacher_id')->widget(Select2::class, [
                'data' => ArrayHelper::map($teachers, 'id', 'Fullname'), /** @see Employee::getFullName() */ // TODO rework to ajax
                'options' => ['placeholder' => 'Выберите преподавателя', 'class' => 'active-form-refresh-control'],
                'theme' => 'default',
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>

            <?= $form->field($model, 'lesson_number')->textInput()->label('Номер урока') ?>

            <?= $form->field($model, 'lesson_topic')->textInput()->label('Тема урока') ?>

            <?= $form->field($model, 'week')->textInput()->label('Неделя') ?>

            <?= $form->field($model, 'type')->widget(Select2::class, [
                'data' => $model->types(), /** @see Employee::getFullName() */ // TODO rework to ajax
                'options' => ['placeholder' => 'Выберите способ', 'class' => 'active-form-refresh-control'],
                'theme' => 'default',
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Способ') ?>


        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
