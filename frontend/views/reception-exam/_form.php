<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReceptionExam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reception-exam-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'commission_id')->textInput() ?>

    <?= $form->field($model, 'institution_discipline_id')->textInput() ?>

    <?= $form->field($model, 'teacher_id')->textInput() ?>

    <?= $form->field($model, 'date_ts')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
