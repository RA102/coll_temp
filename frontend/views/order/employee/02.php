<?php

use common\helpers\PersonHelper;
use common\helpers\PersonTypeHelper;
use common\models\Nationality;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

$this->title = 'Приказ о приеме на работу для ' . $employee->fullName;
?>

<h1><?=$this->title?></h1>

<div class="card-body skin-white">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->widget(\kartik\date\DatePicker::class, [
                    'language' => 'ru',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd.mm.yyyy'
                    ],
            ])->label('Дата'); ?>`

    <?= $form->field($model, 'position')->textInput(['maxlength' => true])->label('Позиция') ?>
    <?php // echo $form->field($model, 'position')->widget(Select2::class, [
                        //'data' => PersonTypeHelper::getList(),
                        //'options' => ['placeholder' => ''],
                        //'theme' => 'default',
                    //]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>