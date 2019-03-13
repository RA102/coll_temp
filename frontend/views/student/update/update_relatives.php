<?php

use common\helpers\PersonRelativeHelper;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\person\Student */
/* @var $activeForm frontend\models\forms\PersonDocumentsForm */
/* @var $activeForm yii\widgets\ActiveForm */
/* @var $relatives \common\models\PersonRelative[] */

?>

<?php $this->beginBlock('update-content') ?>

<?php $activeForm = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<div class="panel panel-default">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item', // required: css class
            'limit' => 10, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $relatives[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'lastname',
                'firstname',
            ],
        ]); ?>

        <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($relatives as $i => $relative): ?>
                <div class="item panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left"><?=Yii::t('app', 'Relative')?></h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        // necessary for update action.
                        if (! $relative->isNewRecord) {
                            echo Html::activeHiddenInput($relative, "[{$i}]id");
                        }
                        ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $activeForm->field($relative, "[{$i}]lastname")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $activeForm->field($relative, "[{$i}]firstname")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $activeForm->field($relative, "[{$i}]middlename")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $activeForm->field($relative, "[{$i}]relation_type")
                                    ->dropDownList(PersonRelativeHelper::getRelationTypeList()) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $activeForm->field($relative, "[{$i}]birth_date")
                                    ->widget(DatePicker::class, [
                                        'language' => 'ru',
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'format' => 'yyyy-mm-dd'
                                        ]
                                    ]); ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $activeForm->field($relative, "[{$i}]iin")
                                    ->widget(\yii\widgets\MaskedInput::class, ['mask' => '999999999999'])
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $activeForm->field($relative, "[{$i}]home_phone")
                                    ->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $activeForm->field($relative, "[{$i}]mobile_phone")
                                    ->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $activeForm->field($relative, "[{$i}]email")
                                    ->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php DynamicFormWidget::end(); ?>
</div>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php $this->endBlock() ?>

<?= $this->render('_update_layout', ['model' => $model]) ?>
