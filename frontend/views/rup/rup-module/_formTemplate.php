<?php

use frontend\models\rup\RupBlock;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use Yii;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupModule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-sub-block-form">

    <?php $templates=\frontend\models\rup\RupModule::find()->where(['isTemplate'=>true])->all();?>
    <?php $listData=ArrayHelper::map($templates,'id','name');?>

    <?php $form = ActiveForm::begin(['options'=>['id'=>'addModuleFormAjaxSerialazi'
        //,'style' => "width: 600px;"

    ]]); ?>

    <?= $form->field($model,'isTemplate')->dropDownList($listData,
        ['prompt'=>'Выберите шаблон','class'=>'form-control addModuleAjaxForm2isTemplate'
         , 'onChange' => "$('.addModuleAjaxForm2isTemplateName').val($(this).find('option:selected').text());"
        ]);?>
    <?= $form->field($model, 'code')->textInput(['class'=>'form-control addModuleAjaxForm2isTemplateCode']) ?>
    <?= $form->field($model, 'rup_id')->hiddenInput(['value'=>$_GET['id']])->label(false) ?>
    <?= $form->field($model, 'block_id')->hiddenInput(['value'=>Yii::$app->request->get('block_id')])->label(false) ?>
    <?= $form->field($model, 'name')->textInput(['class'=>'form-control addModuleAjaxForm2isTemplateName']) ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary','id'=>'subMModuleAdd']) ?>
    </div>

    <?php ActiveForm::end(); ?>


    <script>
        $('#subMModuleAdd').on('click',function (e) {
            //console.log($('.addModuleAjaxForm2isTemplate').val());
            //console.log($('.addModuleAjaxForm2isTemplateCode').val());
            e.preventDefault();
            $('#subMModuleAdd').addClass('hidden');
            $('.rup-sub-block-form').append('<div class="loader"></div>');
            $.ajax({
                type: 'POST',
                url: '/rup/rup-module/createtemplate',
                data: {'isTemplate':$('.addModuleAjaxForm2isTemplate').val(),'code':$('.addModuleAjaxForm2isTemplateCode').val(),
                    'name':$('.addModuleAjaxForm2isTemplateName').val(), 'rup_id':$('#rupblock-rup_id').val(),'block_id':$('#rupmodule-block_id').val()},
                success: function(data){
                    var url= "/rup/rup/update?id="+$('#ruproots-rup_id').val()+"&active=2&block_id="+$('#rupmodule-block_id').val();
                    window.location = url;
                }
            });
        })
    </script>
</div>
