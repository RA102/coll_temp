<?php

use common\models\organization\InstitutionDiscipline;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDepartment */
/* @var $form yii\widgets\ActiveForm */

/** @see Department::caption_current $department */
//$department = ArrayHelper::map(\common\models\Department::find()->all(), 'id', 'caption_current');
?>

<div class="institution-department-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'caption_ru')->textInput() ?>

    <?= $form->field($model, 'caption_kk')->textInput() ?>

    <?= $form->field($model, 'disciplines')->widget(Select2::class, [
        'data' => $disciplines,
        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true
        ],
    ])->label('Дисциплины') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
