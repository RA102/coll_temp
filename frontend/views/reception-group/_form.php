<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReceptionGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reception-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'caption_ru')->textInput() ?>

    <?= $form->field($model, 'caption_kk')->textInput() ?>

    <?= $form->field($model, 'language')->dropDownList(\common\helpers\LanguageHelper::getLanguageList()) ?>

    <?= $form->field($model, 'speciality_id')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map($specialities, 'id', function (\common\models\handbook\Speciality $model) {
            return $model->getCaptionWithCode();
        }),
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>


    <?= $form->field($model, 'education_form')->dropDownList(\common\helpers\GroupHelper::getEducationFormList()) ?>

    <?= $form->field($model, 'budget_places')->textInput() ?>

    <?= $form->field($model, 'commercial_places')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
