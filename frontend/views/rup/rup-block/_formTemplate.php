<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupBlock */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$templates=\frontend\models\rup\RupBlock::find()->where(['isTemplate'=>true])->all();

//use yii\helpers\ArrayHelper;
$listData=ArrayHelper::map($templates,'id','name');

?>
<div class="rup-block-form">


    <?php $form = ActiveForm::begin([ 'options' => ['class'=>'addBlockAjaxForm2','id'=>'addBlockAjaxForm2']]); ?>
    <?= $form->field($model,'isTemplate')->dropDownList($listData,
        ['prompt'=>'Выберите шаблон','class'=>'form-control addBlockAjaxForm2isTemplate'
            , 'onChange' => "$('.addBlockAjaxForm2Name').val($(this).find('option:selected').text());"

        ]);?>
    <?= $form->field($model, 'code')->textInput(['maxlength' => true,'class'=>'form-control addBlockAjaxForm2Code']) ?>
    <?= $form->field($model, 'rup_id')->hiddenInput(['maxlength' => true,'value'=>Yii::$app->request->get('id')])->label(false) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'form-control addBlockAjaxForm2Name']) ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'id'=>'addBlockAjaxSubmit2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <script>
        $('#addBlockAjaxSubmit2').on('click',function (e) {
            console.log($('.addBlockAjaxForm2isTemplate').val());
            console.log($('.addBlockAjaxForm2Code').val());
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '/rup/rup-block/createtemplate',
                data: {'isTemplate':$('.addBlockAjaxForm2isTemplate').val(),'code':$('.addBlockAjaxForm2Code').val(),
                    'name':$('.addBlockAjaxForm2Name').val(), 'rup_id':$('#rupblock-rup_id').val()},
                success: function(data){
                    var url= "/rup/rup/update?id="+$('#ruproots-rup_id').val()+"&active=2";
                    window.location = url;
                }
            });
        })
    </script>
</div>
