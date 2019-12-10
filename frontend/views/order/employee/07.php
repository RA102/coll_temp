<?php

use common\helpers\PersonHelper;
use common\models\Nationality;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

$this->title = 'Пооощрение сотрудника ' . $employee->fullName;
?>

<h1><?=$this->title?></h1>

<div class="card-body skin-white">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'from')->widget(\kartik\date\DatePicker::class, [
                    'language' => 'ru',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd.mm.yyyy'
                    ],
            ])->label('От'); ?>

    <?= $form->field($model, 'reason')->textInput(['maxlength' => true])->label('За') ?>

    <?= $form->field($model, 'percent')->textInput(['maxlength' => true])->label('Процент') ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true])->label('Основание') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>