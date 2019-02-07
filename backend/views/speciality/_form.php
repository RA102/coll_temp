<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\handbook\Speciality */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="speciality-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent_id')->textInput() ?>

    <?= $form->field($model, 'parent_oid')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'code')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'caption')->textInput() ?>

    <?= $form->field($model, 'msko')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gkz')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'server_id')->textInput() ?>

    <?= $form->field($model, 'create_ts')->textInput() ?>

    <?= $form->field($model, 'is_deleted')->checkbox() ?>

    <?= $form->field($model, 'subjects')->textInput() ?>

    <?= $form->field($model, 'is_working')->checkbox() ?>

    <?= $form->field($model, 'institution_type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
