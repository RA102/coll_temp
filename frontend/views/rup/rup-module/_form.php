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

    <?php $form = ActiveForm::begin(['options'=>['id'=>'addModuleFormAjaxSerialazi']]); ?>

    <?= $form->field($model, 'code')->textInput(['required'=>true]) ?>

    <?= $form->field($model, 'rup_id')->hiddenInput(['value'=>$_GET['id']])->label(false) ?>

    <?= $form->field($model, 'block_id')->hiddenInput(['value'=>Yii::$app->request->get('block_id')])->label(false) ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'time')->textInput() ?>
    <?= $form->field($model, 'isTemplate')->checkbox()?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary','id'=>'subModuleAdd']) ?>
    </div>

    <?php ActiveForm::end(); ?>


    <script>
        $('#subModuleAdd').on('click',function (e) {
            e.preventDefault();
            if($('#rupmodule-code').val()==''){
                alert('Индекс не может быть пустым!')
            }
            else{
                $.ajax({
                    type: 'POST',
                    url: '/rup/rup-module/create',
                    data: $('#addModuleFormAjaxSerialazi').serialize(),
                    success: function(data){
                        location.reload();
                    }
                });
            }

        })
    </script>
</div>
