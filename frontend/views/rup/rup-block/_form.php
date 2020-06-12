<?php

use frontend\models\rup\RupQualifications;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupBlock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-block-form">

    <?php $form = ActiveForm::begin([ 'options' => ['class'=>'addBlockAjaxForm']]); 
        $rup_id = Yii::$app->request->get('id');
        $quals = RupQualifications::find()->select(['qualification_code', 'qualification_name']) ->where(['rup_id' => $rup_id])->limit(3)->all();
    
    ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'rup_id')->hiddenInput(['maxlength' => true,'value'=>$rup_id])->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'time')->textInput() ?>

    
    <?= $form->field($model, 'qual_code')->dropDownList(ArrayHelper::map($quals, 'qualification_code', 'qualification_name'), ['prompt' => ''])->label('Квалификация')  ?>

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
