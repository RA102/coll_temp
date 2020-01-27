<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupModuleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-module-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'create') ?>

    <?= $form->field($model, 'update_ts') ?>

    <?php // echo $form->field($model, 'caption_ru') ?>

    <?php // echo $form->field($model, 'caption_kz') ?>

    <?php // echo $form->field($model, 'profession_code') ?>

    <?php // echo $form->field($model, 'study_form') ?>

    <?php // echo $form->field($model, 'profile_id') ?>

    <?php // echo $form->field($model, 'spec_id') ?>

    <?php // echo $form->field($model, 'level_id') ?>

    <?php // echo $form->field($model, 'study_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
