<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupSubjects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-subjects-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_sub_block')->textInput() ?>

    <?= $form->field($model, 'id_block')->textInput() ?>

    <?= $form->field($model, 'exam')->textInput() ?>

    <?= $form->field($model, 'control_work')->textInput() ?>

    <?= $form->field($model, 'offset')->textInput() ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <?= $form->field($model, 'teory_time')->textInput() ?>

    <?= $form->field($model, 'lab_time')->textInput() ?>

    <?= $form->field($model, 'production_practice_time')->textInput() ?>

    <?= $form->field($model, 'one_sem_time')->textInput() ?>

    <?= $form->field($model, 'two_sem_time')->textInput() ?>

    <?= $form->field($model, 'three_sem_time')->textInput() ?>

    <?= $form->field($model, 'four_sem_time')->textInput() ?>

    <?= $form->field($model, 'five_sem_time')->textInput() ?>

    <?= $form->field($model, 'six_sem_time')->textInput() ?>

    <?= $form->field($model, 'seven_sem_time')->textInput() ?>

    <?= $form->field($model, 'eight_sem_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
