<?php

use common\helpers\PersonHelper;
use common\models\Nationality;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\models\forms\StudentGeneralForm */
/* @var $form yii\widgets\ActiveForm */

$blockPersonalDataEditing = $block;
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true, 'disabled'  => $blockPersonalDataEditing]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true, 'disabled'  => $blockPersonalDataEditing]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'middlename')->textInput(['maxlength' => true, 'disabled'  => $blockPersonalDataEditing]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'sex')->dropDownList(PersonHelper::getSexList(), ['disabled'  => $blockPersonalDataEditing]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'birth_date')->widget(DatePicker::class, [
                'language' => 'ru',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy',
                ],
                'disabled'  => $blockPersonalDataEditing
            ]); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'birth_place')->widget(AutoComplete::class, [
                'options' => ['class' => 'form-control', 'disabled'  => $blockPersonalDataEditing],
                'clientOptions' => [
                    'source' => Url::to(['employee/ajax-address']),
                    'minLength' => '5',
                ],
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'nationality_id')
                ->dropDownList(ArrayHelper::map(Nationality::find()->orderBy('name')->all(), 'id', 'name'), ['disabled'  => $blockPersonalDataEditing]); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'iin')
                ->widget(\yii\widgets\MaskedInput::class, ['mask' => '999999999999', 'options' => ['disabled'  => $blockPersonalDataEditing]])
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'language')->dropDownList(\common\helpers\LanguageHelper::getLanguageList(), ['disabled'  => $blockPersonalDataEditing]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'indentity')->textInput(['disabled'  => $blockPersonalDataEditing]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'is_pluralist')->checkbox(['checked' => true], true) ?>        
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
