<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\organization\Institution */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="institution-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country_id')->textInput() ?>

    <?= $form->field($model, 'city_id')->textInput() ?>

    <?= $form->field($model, 'parent_id')->textInput() ?>

    <?= $form->field($model, 'type_id')->textInput() ?>

    <?= $form->field($model, 'educational_form_id')->textInput() ?>

    <?= $form->field($model, 'organizational_legal_form_id')->textInput() ?>

    <?= $form->field($model, 'oid')->textInput() ?>

    <?= $form->field($model, 'server_id')->textInput() ?>

    <?= $form->field($model, 'street_id')->textInput() ?>

    <?= $form->field($model, 'house_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'languages_iso')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'bin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'foundation_year')->textInput() ?>

    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'max_grade')->textInput() ?>

    <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'db_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'db_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'db_password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'initialization')->checkbox() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'create_ts')->textInput() ?>

    <?= $form->field($model, 'update_ts')->textInput() ?>

    <?= $form->field($model, 'delete_ts')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
