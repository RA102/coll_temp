<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\components\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\person\Student */
/* @var $form frontend\models\forms\PersonContactsForm */
/* @var $activeForm yii\widgets\ActiveForm */
?>

<?php $this->beginBlock('update-content') ?>

    <?php
    Pjax::begin([
        'id' => 'list-pjax',
        'formSelector' => '#js-update',
        'scrollTo' => 'false',
    ]);
    ?>
    <?php $activeForm = ActiveForm::begin([
        'id' => 'js-update',
        'enableClientValidation' => false,
        'options' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <?= $activeForm->field($form, 'contact_phone_home')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'contact_phone_mobile')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'person_id')->dropDownList(
        ArrayHelper::map(\common\models\person\Person::find()->all(), 'id', 'firstname'), [
            'class' => 'form-control active-form-refresh-control',
            'prompt' => ''
        ]) ?>

    <?php if ($form->person_id): ?>
    <?= $activeForm->field($form, 'person_contact_id')->dropDownList(
            ArrayHelper::map(\common\models\person\Person::findOne($form->person_id)->personContacts, 'id', 'value')
    ) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

<?php $this->endBlock() ?>

<?= $this->render('_update_layout', ['model' => $model]) ?>
