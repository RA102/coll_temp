<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealApplication */
/* @var $form yii\widgets\ActiveForm */
/* @var $entrants \common\models\person\Entrant[] */
?>

<div class="appeal-application-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'caption_kk')->textInput()->label('Название на казахском') ?>

    <?= $form->field($model, 'caption_ru')->textInput()->label('Название на русском') ?>

    <?= $form->field($model, 'type')->widget(Select2::class, [
        'data' => $types, /** @see Employee::getFullName() */ // TODO rework to ajax
        //'data' => $types, // TODO rework to ajax
        'options' => ['placeholder' => 'Тип', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
