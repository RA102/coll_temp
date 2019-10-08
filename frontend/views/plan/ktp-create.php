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

            <?= $form->field($formmodel, 'lesson_number')->textInput()->label('Номер урока') ?>

            <?= $form->field($formmodel, 'lesson_topic')->textInput()->label('Тема урока') ?>

            <?= $form->field($formmodel, 'week')->textInput()->label('Неделя') ?>

            <?= $form->field($formmodel, 'type')->widget(Select2::class, [
                'data' => $model->teacherCourse->types, 
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
