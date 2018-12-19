<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\person\Employee */
/* @var $form frontend\models\forms\PersonContactsForm */
/* @var $activeForm yii\widgets\ActiveForm */
?>

<?php $this->beginBlock('update-content') ?>

    <?php $activeForm = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-4">
                <?= $activeForm->field($form, 'contact_phone_home')
                    ->textInput(['maxlength' => true])
                    ->widget(\yii\widgets\MaskedInput::class, ['mask' => '+7 (999) 999-99-99',])
                ?>
            </div>
            <div class="col-md-4">
                <?= $activeForm->field($form, 'contact_phone_mobile')
                    ->textInput(['maxlength' => true])
                    ->widget(\yii\widgets\MaskedInput::class, ['mask' => '+7 (999) 999-99-99',])
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

<?php $this->endBlock() ?>

<?= $this->render('_update_layout', ['model' => $model]) ?>
