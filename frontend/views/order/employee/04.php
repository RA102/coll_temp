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

$this->title = 'Приказ об отправлении в командировку сотрудника ' . $employee->fullName;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Приказы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

    <?= $form->field($model, 'to')->widget(\kartik\date\DatePicker::class, [
                    'language' => 'ru',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd.mm.yyyy'
                    ],
            ])->label('До'); ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true])->label('Город') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>