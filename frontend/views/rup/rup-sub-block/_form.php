<?php

use frontend\models\rup\RupBlock;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupSubBlock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rup-sub-block-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput() ?>

    <?= $form->field($model, 'rup_id')->hiddenInput(['value'=>$_GET['id']])->label(false) ?>

    <?= $form->field($model, 'block_id')->dropDownList(ArrayHelper::map(RupBlock::find()->where(['>','id',0])->all(), 'id', 'name'))->label(false) ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success','id'=>'subModuleAdd']) ?>
    </div>

    <?php ActiveForm::end(); ?>


    <script>
        $('#subModuleAdd').on('click',function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '/rup/rup-sub-block/create',
                data: $('#w4').serialize(),
                success: function(data){
                    alert('Всё хорошо');
                }
            });
        })
    </script>
</div>
