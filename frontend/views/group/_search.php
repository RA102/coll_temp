<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\search\GroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'caption') ?>

    <?= $form->field($model, 'language') ?>

    <?= $form->field($model, 'speciality_id') ?>

    <?= $form->field($model, 'max_class') ?>

    <?php // echo $form->field($model, 'class') ?>

    <?php // echo $form->field($model, 'education_form') ?>

    <?php // echo $form->field($model, 'education_pay_form') ?>

    <?php // echo $form->field($model, 'institution_id') ?>

    <?php // echo $form->field($model, 'parent_id') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'rating_system_id') ?>

    <?php // echo $form->field($model, 'based_classes') ?>

    <?php // echo $form->field($model, 'class_change_history') ?>

    <?php // echo $form->field($model, 'properties') ?>

    <?php // echo $form->field($model, 'is_deleted')->checkbox() ?>

    <?php // echo $form->field($model, 'start_ts') ?>

    <?php // echo $form->field($model, 'create_ts') ?>

    <?php // echo $form->field($model, 'update_ts') ?>

    <?php // echo $form->field($model, 'delete_ts') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
