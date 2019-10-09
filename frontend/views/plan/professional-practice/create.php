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

    <?= $form->field($model, 'group_id')->widget(Select2::class, [
        'data' => ArrayHelper::map($groups, 'id', 'caption_current'), /** @see Group::$caption_current */ // TODO rework to ajax
        'options' => ['placeholder' => 'Выберите группу', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'type')->widget(Select2::class, [
        'data' => $types, /** @see Employee::getFullName() */ // TODO rework to ajax
        //'data' => $types, // TODO rework to ajax
        'options' => ['placeholder' => 'Тип', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'weeks[first]')->textInput()->label('Начальная неделя') ?>

    <?= $form->field($model, 'weeks[last]')->textInput()->label('Конечная неделя') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
