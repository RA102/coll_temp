<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupBlock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-block-form">

    <?php $form = ActiveForm::begin([ 'options' => ['class'=>'addBlockAjaxForm']]); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'rup_id')->hiddenInput(['maxlength' => true,'value'=>Yii::$app->request->get('id')])->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time')->textInput() ?>
    <?= $form->field($model, 'isTemplate')->checkbox([
    ])?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'id'=>'addBlockAjaxSubmit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <script>
        $('#addBlockAjaxSubmit').on('click',function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '/rup/rup-block/create',
                data: $('.addBlockAjaxForm').serialize(),
                success: function(data){
                    var url= "/rup/rup/update?id="+$('#ruproots-rup_id').val()+"&active=2";
                    window.location = url;
                }
            });
        })
    </script>
</div>
