<?php

use common\helpers\PersonHelper;
use common\models\Nationality;
use kartik\date\DatePicker;
use kartik\select2\Select2;
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

        <div class="row">
            <div class="col-md-4">
                <?= $activeForm->field($form, 'firstname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $activeForm->field($form, 'lastname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $activeForm->field($form, 'middlename')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?= $activeForm->field($form, 'sex')->dropDownList(PersonHelper::getSexList()) ?>
            </div>
            <div class="col-md-4">
                <?= $activeForm->field($form, 'birth_date')->widget(DatePicker::class, [
                    'language' => 'ru',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]); ?>
            </div>
            <div class="col-md-4">
                <?= $activeForm->field($form, 'birth_place')->widget(AutoComplete::class, [
                    'options' => ['class' => 'form-control'],
                    'clientOptions' => [
                        'source' => Url::to(['employee/ajax-address']),
                        'minLength' => '5',
                    ],
                ]); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?php // Should it be form or model?? Validation fails ?>
                <?= $activeForm->field($form, 'nationality_id')->widget(Select2::classname(), [
                        'data' => \yii\helpers\ArrayHelper::map(Nationality::find()->all(), 'id', 'name'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>
            </div>
            <div class="col-md-4">
                <?= $activeForm->field($form, 'iin')
                    ->widget(\yii\widgets\MaskedInput::class, ['mask' => '999999999999'])
                ?>
            </div>
            <div class="col-md-4">
                <?= $activeForm->field($model, 'language')->dropDownList(\common\helpers\LanguageHelper::getLanguageList()) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

<?php $this->endBlock() ?>

<?= $this->render('_update_layout', ['model' => $model]) ?>