<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDiscipline */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="institution-discipline-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'discipline_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(\common\models\Discipline::find()->all(), 'id', 'caption'), // TODO rework to ajax
        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'types')->widget(Select2::class, [
        'data' => \common\helpers\DisciplineHelper::getTypeList(),
        'options' => [
            'placeholder' => '...',
            'class' => 'active-form-refresh-control',
            'multiple' => true,
        ],
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
