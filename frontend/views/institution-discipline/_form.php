<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDiscipline */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="institution-discipline-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'institution_id')->textInput() ?>

    <?= $form->field($model, 'discipline_id')->textInput() ?>

    <?= $form->field($model, 'types')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
