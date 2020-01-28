<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\rup\RupRoots */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-roots-form">
    <?= Html::a('Добавить РУП', ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Открыть', ['create'], ['class' => 'btn btn-warning']) ?>
    <?= Html::a('Сохранить в файл', ['create'], ['class' => 'btn btn-info']) ?>
    <?= Html::a('Экспорт в Excel', ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Сделать копию', ['create'], ['class' => 'btn btn-danger']) ?>
    <?php $form = ActiveForm::begin(['action' => ['comments/ajax-comment'],
    'options' => [
        'class' => 'comment-form',
        'style'=>[
                'width'=>'70%'
        ]
    ]]); ?>
    <?= $form->field($model, 'rup_id',['options' => ['class' => 'sem']])->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'captionRu',['options' => ['class' => 'sem']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rup_year',['options' => ['class' => 'trid']])->dropDownList([0=>'2018',1=>'2019',2=>'2020',3=>'2021']) ?>
    <?= $form->field($model, 'profile_code',['options' => ['class' => 'sem']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'edu_form',['options' => ['class' => 'trid']])->dropDownList([0=>'Очная',1=>'Заочная']) ?>
    <?= $form->field($model, 'spec_code',['options' => ['class' => '']])->textInput(['maxlength' => true]) ?>



    <div class="form-group">

        <?= Html::submitButton('Изменить', ['class' => 'btn btn-success']) ?>

    </div>

    <style>
        .sem{
            width:70%;
            float:left;
        }
        .trid{
            width:30%;
            float:right;
        }
    </style>
    <?php ActiveForm::end(); ?>
</div>
