<?php

use common\models\handbook\Speciality;
use common\models\organization\InstitutionSpecialityInfo;
use frontend\models\rup\Profile;
use frontend\models\rup\RupQualifications;
use kartik\depdrop\DepDrop;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\rup\RupRoots */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-roots-form">

    <!-- <?= Html::a('Открыть', ['create'], ['class' => 'btn btn-light nextVersion']) ?>
    <?= Html::a('Сохранить в файл', ['create'], ['class' => 'btn btn-light nextVersion']) ?>
    <?= Html::a('Экспорт в Excel', ['create'], ['class' => 'btn btn-light nextVersion']) ?>
    <?= Html::a('Сделать копию', ['create'], ['class' => 'btn btn-light nextVersion']) ?> -->
    <?=Html::submitButton('Сохранить план', ['class' => 'btn btn-success btn-margin','id'=>'rup_save','style'=>[]]);?>

    <?php
        echo  Html::button('Открыть для редактирования', ['id'=>'rupEditOpen','class' => 'btn btn-light btn-margin','style'=>[]]);
        echo  Html::button('Закрыть для редактирования', ['id'=>'rupEditClose','class' => 'btn btn-light btn-margin','style'=>[]]);
        echo Html::a('Экспорт в Excel', ['/rup/rup-block/test'."?rup_id=".$model->rup_id], ['class' => 'btn btn-success']);
        echo  Html::button('Удалить', ['id'=>'rupEditDelete','class' => 'btn btn-danger btn-margin','style'=>[]]);
    ?>
    <?php $form = ActiveForm::begin(['action' => ['/rup/rup/update'],
        'options' => [
            'class' => 'comment-form',
            'style'=>[
                    'width'=>'70%'
            ]
        ]]); 
        $code = substr($model->profile_code,0,2) . '%';
        $sp = Speciality::find()->select(["code", "caption"])->where(['type' => '2'])->andWhere(['like', 'code', $code, false])->all();

    
    ?>
    <?= $form->field($model, 'rup_id',['options' => ['class' => 'sem']])->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'status',['options' => ['class' => 'sem']])->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'captionRu',['options' => ['class' => 'sem']])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'rup_year',['options' => ['class' => 'trid']])->dropDownList([2020=>'2020',2021=>'2021']) ?>
    <?= $form->field($model, 'profile_code',['options' => ['class' => 'sem']])->dropDownList(ArrayHelper::map(Speciality::find()->where(['type' => '1'])->all(), 'code', 'CaptionWithCode'))->label('Профиль')  ?>
    <?= $form->field($model, 'edu_form',['options' => ['class' => 'trid']])->dropDownList([0=>'Очная',1=>'Заочная']) ?>
    <?= $form->field($model, 'spec_code',['options' => ['class' => '']])->dropDownList(ArrayHelper::map($sp, 'code', 'CaptionWithCode'))->label("Специальность") ?>


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
    Modal::begin([

        'header' => '<h2>Добавить квалификации</h2>',
        'toggleButton' => ['label' => 'Добавить квалификации','class'=>'btn btn-success','style'=>['margin'=>'5px;']],
        'size'=>'modal-lg',
    ]);
    echo $this->renderAjax('/rup/rup-qualifications/_form',['model'=> $Model=new RupQualifications(), 'parent_code' => $model->spec_code]);
    Modal::end();
    
    echo "<br><table style='background-color: white; width: 80%; ' class='table table-striped  table-bordered '>
            <tr style='background-color: darkgray'>
                <th>Квалификации</th>
                <th>Срок</th>
                <th>Уровень</th>
                <th></th>
            </tr>";


    foreach ($qualifications as $q){
        $id = $q['id'];
        $code = $q['qualification_code'];
        $name = $q['qualification_name'];
        $time = $q['time_years']." год(а) ".$q['time_months']." месяц(ев)";
        $level = $q['q_level'];

        echo " <tr qualId='{$id}'><td>{$name}</td><td>{$time}</td><td>{$level}</td><td>
                <button title='Удалить' style='margin-left:5%; margin-top: 1%;margin-bottom: 1%;' class='btn btn-danger delete_qual' id='{$id}'><span class='glyphicon glyphicon-trash'></button>
                </td></tr>
        ";
    }

    echo "  </table>";



    ?>


</div>
<style>
    .btn-margin{
        margin:5px;
    }
    .loader {
        position: fixed;
        z-index: 99999;
        top:37%;
        left:43%;
        border: 16px solid #464646; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<script>


    function get_qualifications(){
        $.ajax({
            type: 'GET',
            url: '/rup/rup/get-qualifications',
            data: {'parent_code': $('select[name="RupRoots[spec_code]"]').val()}, 
            success: function(data){
                $("#rupqualifications-qualification_code").html( data );
            }
        });        
    };

    function get_specialities(){
        $.ajax({
            type: 'GET',
            url: '/rup/rup/get-specialities',
            data: {'parent_code': $('select[name="RupRoots[profile_code]"]').val()}, 
            success: function(data){
                $("#ruproots-spec_code").html( data );
            }
        });        
    };

    // $(document).ready(function() {
    //     get_specialities(); 
    //     get_qualifications()
    // });

    // $(window).on('load', function() {
    //     //$('#ruproots-profile_code').onchange();
    //     get_specialities(); 
    //          //get_qualifications()
    // });

    $('#ruproots-profile_code').on('change',function (e) {
        e.preventDefault();
        get_specialities(); 
    });

    $('#ruproots-spec_code').on('change',function (e) {
        e.preventDefault();
        get_qualifications(); 
        
    });

    $('.delete_qual').on('click',function () {
        if (confirm('Вы действительно хотите удалить?')) {
            $.ajax({
                type: 'GET',
                url: '/rup/rup-qualifications/delete-from-rup',
                data: {'id':this.id},
                success: function(data){
                    location.reload();
                }
            });
        } else {
        }

    });


    
    $('#rupEditDelete').on('click',function (e) {
        var rup_id=$('#ruproots-rup_id').val()
        e.preventDefault();
        //$('#rupqualifications-rup_id').val(rup_id);
        //var param = $('#w2').serialize();
        //console.log(param);
        $.ajax({
            type: 'POST',
            url: '/rup/rup/delete'+'?id='+$('#ruproots-rup_id').val(),
            data: '',

            success: function(data){
                location.reload();
            }
        });
        //$('#w2').fadeToggle();
        //$('#w2').css('display:none');
        //$('.modal-backdrop').remove();
    });

    $('#submitQualification').on('click',function (e) {
        var rup_id=$('#ruproots-rup_id').val()
        e.preventDefault();
        $('#rupqualifications-rup_id').val(rup_id);
        var param = $('#w2').serialize();
        //console.log(param);
        $.ajax({
            type: 'POST',
            url: '/rup/rup-qualifications/create',
            data: param,

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
        if (confirm('Вы действительно хотите закрыть план для редактирования??')) {
            $('#ruproots-status').val('0');
            $('#w0 input[type="text"]').prop("disabled", true);
            $('#w0 select').prop("disabled", true);
            $('#rup_save').hide();
            $('#rup_save').click();
            var url= "/rup/rup/view?id="+$('#ruproots-rup_id').val()+"&active=1";
            if (url != null){
                window.location = url;
            }
            
        } else {
        }
    })
    $('#rupEditOpen').on('click',function (e) {
        e.preventDefault();
        if (confirm('Вы действительно хотите открыть план для редактирования??')) {
            $('#ruproots-status').val('1');
            $('#w0 input[type="text"]').prop("disabled", false);
            $('#w0 select').prop("disabled", false);
            $('#rup_save').show();
            $('#rup_save').click();
        } else {
        }

    })




    $('.nextVersion').on('click',function (e) {
        e.preventDefault();
        alert('Это планируется в следующей версии');
    });




</script>