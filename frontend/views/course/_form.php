<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Course */
/* @var $form yii\widgets\ActiveForm */
/* @var $institutionDisciplines common\models\organization\InstitutionDiscipline[] */
/* @var $classes array */

/** @see InstitutionDiscipline::caption_current */
$institutionDisciplines = ArrayHelper::map($institutionDisciplines, 'id', 'caption_current');
?>

<div class="course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'institution_discipline_id')->widget(Select2::class, [
        'data' => $institutionDisciplines, // TODO rework to ajax
        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'caption_ru')->textInput() ?>

    <?= $form->field($model, 'caption_kk')->textInput() ?>

    <?= $form->field($model, 'classes')->widget(Select2::class, [
        'data' => $classes,
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
