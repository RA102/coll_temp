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

$this->title = 'Приказ об условном переводе для ' . $group->caption_current;
?>

<h1><?=$this->title?></h1>

<div class="card-body skin-white">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'season')->textInput(['maxlength' => true])->label('Учебный год (Например: 2018-2019)') ?>
    
    <?= $form->field($model, 'year')->textInput(['maxlength' => true])->label('Год') ?>

    <?= $form->field($model, 'new_class')->textInput(['maxlength' => true])->label('На курс') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>