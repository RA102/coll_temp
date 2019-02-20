<?php

use common\helpers\PersonHelper;
use common\models\Nationality;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\forms\StudentGeneralForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->dropDownList(PersonHelper::getSexList()) ?>

    <?= $form->field($model, 'birth_date')->widget(DatePicker::class, [
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]); ?>

    <?= $form->field($model, 'birth_place')->widget(AutoComplete::class, [
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'source' => Url::to(['student/ajax-address']),
            'minLength' => '5',
        ],
    ]); ?>


    <?= $form->field($model, 'nationality_id')->dropDownList(\yii\helpers\ArrayHelper::map(Nationality::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'iin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language')->dropDownList(\common\helpers\LanguageHelper::getLanguageList()) ?>

    <?= $form->field($model, 'generate_credential')->checkbox() ?>

    <?= $form->field($model, 'indentity')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
