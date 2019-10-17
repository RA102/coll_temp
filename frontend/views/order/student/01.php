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

$this->title = 'Приказ о восстановлении для ' . $student->fullName;
?>

<h1><?=$this->title?></h1>

<div class="card-body skin-white">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'new_group')->widget(Select2::class, [
        'data' => ArrayHelper::map($groups, 'caption_current', 'caption_current'), /** @see Employee::getFullName() */ // TODO rework to ajax
        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label('Группа для зачисления') ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true])->label('Примечание') ?>

    <?= $form->field($model, 'year')->textInput(['maxlength' => true])->label('Год восстановления') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>