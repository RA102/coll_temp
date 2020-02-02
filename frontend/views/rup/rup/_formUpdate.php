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
    <?= Html::a('Открыть', ['create'], ['class' => 'btn btn-light']) ?>
    <?= Html::a('Сохранить в файл', ['create'], ['class' => 'btn btn-light']) ?>
    <?= Html::a('Экспорт в Excel', ['create'], ['class' => 'btn btn-light']) ?>
    <?= Html::a('Сделать копию', ['create'], ['class' => 'btn btn-light']) ?>
    <?php $form = ActiveForm::begin(['action' => ['/rup/rup/update'],
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
    <?php
    echo  Html::button('Удалить', ['class' => 'btn btn-light btn-margin','style'=>['float'=>'left','margin'=>'10px;']]);
    echo  Html::button('Открыть для редактирования', ['id'=>'rupEditOpen','class' => 'btn btn-light btn-margin','style'=>['float'=>'left','margin'=>'10px;']]);
    echo  Html::button('Закрыть для редактирования', ['id'=>'rupEditClose','class' => 'btn btn-light btn-margin','style'=>['float'=>'left','margin'=>'10px;']]);
    ?>
    <?=Html::submitButton('Сохранить план', ['class' => 'btn btn-success btn-margin','id'=>'rup_save','style'=>['float'=>'right','margin'=>'10px']]);?>
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
    echo "<table style='background-color: white; width: 70%; ' class='table table-striped  table-bordered '>
   <tr style='background-color: darkgray'>
    <th>Квалификация</th>
    <th>Срок</th>
    <th>Уровень</th>
    <th></th>
   </tr>";


    foreach ($qualifications as $q){
        $id = $q['id'];
        $name = $q['qualification_name'];
        $time = $q['time_years']." года ".$q['time_months']." Месяцев";
        $level = $q['q_level'];
        echo "

   <tr qualId='{$id}'><td>{$name}</td><td>{$time}</td><td>{$level}</td><td><button style='margin-left:7%; margin-top: 1%;margin-bottom: 1%;' class='btn btn-danger delete_qual' id='{$id}'><span class='glyphicon glyphicon-trash'></button><button data-target='#editModal' data-toggle='modal' style='margin-left:5%;' class='btn btn-success edit_qual' qualEditButtonId='{$id}'><h7><i class=\"fas fa-edit\"></i></h7></button></td></tr>

        ";
    }

    echo "  </table>";


    Modal::begin([
        'header' => '<h2>Добавить</h2>',
        'toggleButton' => ['label' => 'Добавить','class'=>'btn btn-success','style'=>['margin-top'=>'5px;','margin-left'=>'60%']],


    ]);

    echo $this->renderAjax('/rup/rup-qualifications/_form',['model'=> $Model=new RupQualifications()]);

    Modal::end();


    echo "<br>";
    ?>


</div>
<style>
    .btn-margin{
        margin:5px;
    }
</style>
<script>
    $('.delete_qual').on('click',function () {

        $.ajax({
            type: 'GET',
            url: '/rup/rup-qualifications/delete-from-rup',
            data: {'id':this.id},
            success: function(data){
                location.reload();
            }
        });
    });


    $('#submitQualification').on('click',function (e) {
        var rup_id=$('#ruproots-rup_id').val()
        e.preventDefault();
        $('#rupqualifications-rup_id').val(rup_id);
        $.ajax({
            type: 'POST',
            url: '/rup/rup-qualifications/create',
            data: $('#w2').serialize(),
            success: function(data){
                location.reload();
            }
        });
        $('#w2').fadeToggle();
        $('#w2').css('display:none');
        $('.modal-backdrop').remove();
    });




    $('#rup_save').on('click',function (e) {
        e.preventDefault();
        $('#modal').modal();
        $.ajax({
            type: 'POST',
            url: '/rup/rup/update'+'?id='+$('#ruproots-rup_id').val(),
            data: $('#w0').serialize(),
            success: function(data){
                alert('Успешно обновлено, сейчас страница обновиться');
                // location.reload();
            }
        });
    })

    $('#rupEditClose').on('click',function (e) {
        e.preventDefault();
        $('#w0 input[type="text"]').prop("disabled", true);
        $('#w0 select').prop("disabled", true);
        $('#rup_save').hide();
    })
    $('#rupEditOpen').on('click',function (e) {
        e.preventDefault();
        $('#w0 input[type="text"]').prop("disabled", false);
        $('#w0 select').prop("disabled", false);
        $('#rup_save').show();
    })

    $('.edit_qual').on('click',function () {
        $('#editModalBody').html("<form id='editedForm{id}'>");
        var id = $(this).attr('qualeditbuttonid');
        $('tr[qualid='+id+']').find('td').each (function( column, td) {
        if (column==0){
            $('#editModalBody').append("<div><b>Квалификация</b><input class='form-control' type='text' value='"+td.innerHTML+"'></input></div>");
        }
        else if(column==1){
            thenum = td.innerHTML.match(/\d+/)[0];
            var thenum2;
            if(td.innerHTML.match(/\d+/)[1]==undefined){
                thenum2=td.innerHTML.match(/\d\d+/)[0];
            }
            else{
                thenum2=td.innerHTML.match(/\d+/)[1];
            }
            $('#editModalBody').append("<div><b>Срок обучения лет:</b><input class='form-control' type='text' value='"+thenum+"'></input><b>Срок обучения месяцев:</b><input class='form-control' type='text' value='"+thenum2+"'></input></div>");

        }
        else if(column==2){
            $('#editModalBody').append("<div><b>Уровень</b><input class='form-control' type='text' value='"+td.innerHTML+"'></input></div>");

            }

        });

        $('#editModalBody').append("</form>");
    });




    function makeForm(id,formclass) {
        alert(id);


        // $('#'+this.id).each(function( index ) {
        //     console.log( index + ": " + $( this ).text() );
        // });

    }
</script>