<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\helpers\SpecialityHelper;

/* @var $this yii\web\View */
/* @var $model common\models\handbook\Speciality */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $this->beginBlock('content') ?>
<div class="speciality-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="col-md-12">
                <?= $form->field($model, 'caption')->textInput() ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'institution_type')
                    ->dropDownList(SpecialityHelper::getInstitutionTypes()) ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'code')->textInput() ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12">
                <?= $form->field($model, 'gkz')->textInput() ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'msko')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>