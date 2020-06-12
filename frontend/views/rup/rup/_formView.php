<?php

use frontend\models\rup\RupQualifications;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\rup\RupRoots */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-roots-form">
    <?= Html::a('Сохранить в файл', ['#'], ['class' => 'btn btn-light hidden']) ?>
    <?= Html::a('Экспорт в Excel', ['#'], ['class' => 'btn btn-light hidden']) ?>
    <?= Html::a('Сделать копию', ['#'], ['class' => 'btn  btn-light hidden']) ?>
    <?php
    echo  Html::button('Удалить', ['class' => 'btn  hidden btn-light btn-margin','style'=>[]]);
    echo  Html::button('Открыть для редактирования', ['id'=>'rupEditOpen','class' => 'btn btn-light btn-margin','style'=>[]]);
    echo  Html::button('Закрыть для редактирования', ['id'=>'rupEditClose','class' => 'btn btn-light btn-margin hidden','style'=>[]]);
    ?>
    <?php $form = ActiveForm::begin(['action' => ['/rup/rup/update'],
    'options' => [
        'class' => 'comment-form',
        'style'=>[
                'width'=>'70%'
        ]
    ]]); ?>
    <?= $form->field($model, 'rup_id',['options' => ['class' => 'sem']])->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'status',['options' => ['class' => 'sem']])->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'captionRu',['options' => ['class' => 'sem']])->textInput(['maxlength' => true, 'disabled' => true]) ?>
    <?= $form->field($model, 'rup_year',['options' => ['class' => 'trid']])->dropDownList([0=>'2018',1=>'2019',2=>'2020',3=>'2021'], ['disabled' => 'disabled']) ?>
    <?= $form->field($model, 'profile_code',['options' => ['class' => 'sem']])->textInput(['maxlength' => true, 'disabled' => true]) ?>
    <?= $form->field($model, 'edu_form',['options' => ['class' => 'trid']])->dropDownList([0=>'Очная',1=>'Заочная'],['disabled' => 'disabled']) ?>
    <?= $form->field($model, 'spec_code',['options' => ['class' => '']])->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?=Html::submitButton('Сохранить план', ['class' => 'btn btn-success btn-margin hidden','id'=>'rup_save','style'=>['float'=>'right','margin'=>'10px']]);?>
    <?php ActiveForm::end(); ?>

    <div class="form-group">



    </div>

    <style>
        .sem{
            width:68%;
            float:left;
        }
        .trid{
            width:30%;
            float:right;
        }
    </style>


    <?php
    echo "<table style='background-color: white; width: 80%; ' class='table table-striped  table-bordered '>
   <tr style='background-color: darkgray'>
    <th>Квалификация</th>
    <th>Срок</th>
    <th>Уровень</th>
   </tr>";


    foreach ($qualifications as $q){
        $id = $q['id'];
        $name = $q['qualification_name'];
        $time = $q['time_years']." года ".$q['time_months']." Месяцев";
        $level = $q['q_level'];
        $code = $q['qualification_code'];
        echo "

   <tr qualId='{$id}'><td>{$code}-{$name}</td><td>{$time}</td><td>{$level}</td></tr>

        ";
    }

    echo "  </table>";


    echo "<br>";
    ?>


</div>
<style>
    .btn-margin{
        margin:5px;
    }
</style>
