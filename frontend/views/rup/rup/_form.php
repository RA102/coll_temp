<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\rup\RupRoots */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-roots-form">

    <?php $form = ActiveForm::begin(['action' => ['/rup/rup/create'],
        'options' => [
            'class' => 'comment-form',
            'style'=>[
                'width'=>'70%'
            ]
        ]]); ?>
    <?= $form->field($model, 'rup_id',['options' => ['class' => 'sem']])->hiddenInput()->label(false) ?>
<!--    --><?//= $form->field($model, 'create_ts',['options' => ['class' => 'sem']])->hiddenInput(['value'=>time('U')])->label(false) ?>
    <?= $form->field($model, 'status',['options' => ['class' => 'sem']])->hiddenInput(['value'=>1])->label(false) ?>
    <?= $form->field($model, 'captionRu',['options' => ['class' => 'sem']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'rup_year',['options' => ['class' => 'trid']])->dropDownList([2018=>'2018',2019=>'2019',2020=>'2020',2021=>'2021']) ?>
    <?= $form->field($model, 'profile_code',['options' => ['class' => 'sem']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'edu_form',['options' => ['class' => 'trid']])->dropDownList([0=>'Очная',1=>'Заочная']) ?>
    <?= $form->field($model, 'spec_code',['options' => ['class' => '']])->textInput(['maxlength' => true]) ?>
    <?=Html::submitButton('Добавить план', ['class' => 'btn btn-success btn-margin','id'=>'rup_save','style'=>[]]);?>
    <?php ActiveForm::end(); ?>

</div>
