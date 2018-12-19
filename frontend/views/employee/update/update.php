<?php

use common\helpers\PersonHelper;
use common\models\Nationality;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\person\Employee */
/* @var $form frontend\models\forms\StudentGeneralForm */
/* @var $activeForm yii\widgets\ActiveForm */
?>

<?php $this->beginBlock('update-content') ?>

    <?php $activeForm = ActiveForm::begin(); ?>

    <?= $activeForm->field($form, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'lastname')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'middlename')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'sex')->dropDownList(PersonHelper::getSexList()) ?>

    <?= $activeForm->field($form, 'birth_date')->widget(DatePicker::class, [
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]); ?>

    <?= $activeForm->field($form, 'birth_place')->widget(AutoComplete::class, [
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'source' => Url::to(['employee/ajax-address']),
            'minLength' => '5',
        ],
    ]); ?>


    <?= $activeForm
        ->field($form, 'nationality_id')
        ->dropDownList(\yii\helpers\ArrayHelper::map(Nationality::find()->all(), 'id', 'name')) ?>

    <?= $activeForm->field($form, 'iin')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'language')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

<?php $this->endBlock() ?>

<?= $this->render('_update_layout', ['model' => $model]) ?>