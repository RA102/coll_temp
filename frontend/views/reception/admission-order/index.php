<?php

use common\helpers\EducationHelper;
use common\helpers\ReceptionExamHelper;
use common\models\reception\AdmissionProtocol;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this \yii\web\View */
/* @var $searchModel \frontend\search\AppealApplicationSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $form \frontend\models\forms\EntranceExamOrderForm */
/* @var $protocols \common\models\reception\AdmissionProtocol[] */

$this->title = Yii::t('app', 'Order of admission to entrance exams');
?>

<h1><?=$this->title?></h1>

<div class="group-index skin-white">
    <div class="card-header">
        <?=Yii::t('app', 'Form document')?>
    </div>

    <div class="card-body">
        <?php $activeForm = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-4">
                <?= $activeForm->field($form, 'education_form')->dropDownList(
                    EducationHelper::getEducationFormTypes(),
                    ['prompt' => Yii::t('app', 'Выбрать')]
                ) ?>
            </div>
            <div class="col-md-4">
                <?= $activeForm->field($form, 'education_pay_form')->dropDownList(
                    EducationHelper::getPaymentFormTypes(),
                    ['prompt' => Yii::t('app', 'Выбрать')]
                ) ?>
            </div>
            <div class="col-md-4">
                <?= $activeForm->field($form, 'language')->dropDownList(
                    \common\helpers\LanguageHelper::getLanguageList(),
                    ['prompt' => Yii::t('app', 'Выбрать')]
                ) ?>
            </div>
            <div class="col-md-4">
                <?= $activeForm->field($form, 'exam_form')->dropDownList(
                    ReceptionExamHelper::getTypeList(),
                    ['prompt' => Yii::t('app', 'Выбрать')]
                ) ?>
            </div>
            <div class="col-md-4">
                <?= $activeForm->field($form, 'based_classes')->dropDownList(
                    \common\helpers\ApplicationHelper::getBasedClassesArray(),
                    ['prompt' => Yii::t('app', 'Выбрать')]
                ) ?>
            </div>
            <div class="col-md-4">
                <?= $activeForm->field($form, 'date')->widget(DatePicker::class, [
                    'language' => 'ru',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]); ?>
            </div>
            <div class="col-md-4">
                <?= $activeForm->field($form, 'protocol_number')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Form'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>