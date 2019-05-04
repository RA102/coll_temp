<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReceptionExamGrade */
/* @var $receptionGroup common\models\ReceptionGroup */
/* @var $receptionExam common\models\ReceptionExam */
/* @var $entrant common\models\person\Entrant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reception-exam-grade-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gradeWrapper')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
