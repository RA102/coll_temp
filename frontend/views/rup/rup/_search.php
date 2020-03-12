<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\rup\RupRootsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-roots-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'rup_id') ?>

    <?= $form->field($model, 'rup_year')->dropDownList([0=>'2018',1=>'2019',2=>'2020',3=>'2021'], ['disabled' => 'disabled']) ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'create_ts') ?>

    <?= $form->field($model, 'delete_ts') ?>

    <?php // echo $form->field($model, 'lastopen_ts') ?>

    <?php // echo $form->field($model, 'lastclose_ts') ?>

    <?php // echo $form->field($model, 'create_userid') ?>

    <?php // echo $form->field($model, 'delete_userid') ?>

    <?php // echo $form->field($model, 'lastopen_userid') ?>

    <?php // echo $form->field($model, 'lastclose_userid') ?>

    <?php // echo $form->field($model, 'captionRu') ?>

    <?php // echo $form->field($model, 'captionKz') ?>

    <?php // echo $form->field($model, 'lang') ?>

    <?php // echo $form->field($model, 'profile_code') ?>

    <?php // echo $form->field($model, 'spec_code') ?>

    <?php // echo $form->field($model, 'edu_form') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
