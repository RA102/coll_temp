<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $admissionProtocolForm \frontend\models\forms\AdmissionProtocolForm */
/* @var $commissionMembers \common\models\person\Person[] */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admission-protocol-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($admissionProtocolForm, 'number')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($admissionProtocolForm, 'completion_date')->widget(\kartik\date\DatePicker::class, [
                'language'      => 'ru',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format'    => 'dd-mm-yyyy'
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($admissionProtocolForm,
                'commission_members')->widget(\unclead\multipleinput\MultipleInput::class,
                [
                    'form'        => $form,
                    'columnClass' => \common\components\MultipleInputColumn::class,
                    'min'         => 1,
                    'max'         => 10,
                    'columns'     => [
                        [
                            'name'        => 'person_id',
                            'type'        => \kartik\select2\Select2::class,
                            'title'       => Yii::t('app', 'Commission members'),
                            'enableError' => true,
                            'options'     => [
                                'data'    => \yii\helpers\ArrayHelper::map($commissionMembers, 'id', 'fullName'),
                                'theme'   => 'default',
                                'options' => ['placeholder' => Yii::t('app', 'Поиск')],
                            ]
                        ],
                    ]
                ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($admissionProtocolForm, 'agendas')->widget(\unclead\multipleinput\MultipleInput::class,
                [
                    'min'         => 1,
                    'max'         => 10,
                    'columnClass' => \common\components\MultipleInputColumn::class,
                    'columns'     => [
                        [
                            'name'        => 'text',
                            'type'        => 'textarea',
                            'title'       => Yii::t('app', 'Повестка дня'),
                            'items'       => [],
                            'enableError' => true,
                        ],
                    ]
                ])->label(false);
            ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
