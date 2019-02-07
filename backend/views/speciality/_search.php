<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\search\handbook\SpecialitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="speciality-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'parent_id') ?>

    <?= $form->field($model, 'parent_oid') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'code') ?>

    <?php // echo $form->field($model, 'caption') ?>

    <?php // echo $form->field($model, 'msko') ?>

    <?php // echo $form->field($model, 'gkz') ?>

    <?php // echo $form->field($model, 'server_id') ?>

    <?php // echo $form->field($model, 'create_ts') ?>

    <?php // echo $form->field($model, 'is_deleted')->checkbox() ?>

    <?php // echo $form->field($model, 'subjects') ?>

    <?php // echo $form->field($model, 'is_working')->checkbox() ?>

    <?php // echo $form->field($model, 'institution_type') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
