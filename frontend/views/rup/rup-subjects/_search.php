<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupSubjectsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-subjects-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_sub_block') ?>

    <?= $form->field($model, 'id_block') ?>

    <?= $form->field($model, 'exam') ?>

    <?= $form->field($model, 'control_work') ?>

    <?php // echo $form->field($model, 'offset') ?>

    <?php // echo $form->field($model, 'time') ?>

    <?php // echo $form->field($model, 'teory_time') ?>

    <?php // echo $form->field($model, 'lab_time') ?>

    <?php // echo $form->field($model, 'production_practice_time') ?>

    <?php // echo $form->field($model, 'one_sem_time') ?>

    <?php // echo $form->field($model, 'two_sem_time') ?>

    <?php // echo $form->field($model, 'three_sem_time') ?>

    <?php // echo $form->field($model, 'four_sem_time') ?>

    <?php // echo $form->field($model, 'five_sem_time') ?>

    <?php // echo $form->field($model, 'six_sem_time') ?>

    <?php // echo $form->field($model, 'seven_sem_time') ?>

    <?php // echo $form->field($model, 'eight_sem_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
