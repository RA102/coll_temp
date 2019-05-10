<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $admissionProtocol \common\models\reception\AdmissionProtocol */
/* @var $commission \common\models\reception\Commission */
/* @var $possibleSpeakers \common\models\person\Person[] */
/* @var $protocolIssueForm \frontend\models\reception\admission_protocol\ProtocolIssueForm */
/* @var $receptionGroups \common\models\ReceptionGroup[] */

$this->title = Yii::t('app', 'Рассмотрели');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commissions'), 'url' => ['/commission/index']];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Commission'),
    'url'   => ['/commission/view', 'id' => $commission->id]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Reports'),
    'url'   => ['/report/index', 'commission_id' => $commission->id]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Protocols'),
    'url'   => ['/report/protocol/index', 'commission_id' => $commission->id]
];
$this->params['breadcrumbs'][] = [
    'label' => $admissionProtocol->number,
    'url'   => ['/report/protocol/view', 'commission_id' => $commission->id, 'id' => $admissionProtocol->id]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>
<?php $this->beginBlock('content') ?>
<div class="admission-protocol-issue-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($protocolIssueForm, 'decree')->textarea() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($protocolIssueForm, 'listeners')->widget(\unclead\multipleinput\MultipleInput::class,
                [
                    'form'        => $form,
                    'columnClass' => \common\components\MultipleInputColumn::class,
                    'min'         => 1,
                    'max'         => 5,
                    'columns'     => [
                        [
                            'name'        => 'person_id',
                            'type'        => \kartik\select2\Select2::class,
                            'title'       => Yii::t('app', 'Listened'),
                            'enableError' => true,
                            'options'     => [
                                'data'    => \yii\helpers\ArrayHelper::map($commission->members, 'id', 'fullName'),
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
            <?= $form->field($protocolIssueForm, 'speakers')->widget(\unclead\multipleinput\MultipleInput::class,
                [
                    'form'        => $form,
                    'columnClass' => \common\components\MultipleInputColumn::class,
                    'min'         => 1,
                    'max'         => 10,
                    'columns'     => [
                        [
                            'name'        => 'person_id',
                            'type'        => \kartik\select2\Select2::class,
                            'title'       => Yii::t('app', 'Speakers'),
                            'enableError' => true,
                            'options'     => [
                                'data'    => \yii\helpers\ArrayHelper::map($possibleSpeakers, 'id', 'fullName'),
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
            <?= $form->field($protocolIssueForm, 'reception_group_id')->widget(\kartik\select2\Select2::class, [
                'data'          => \yii\helpers\ArrayHelper::map($receptionGroups, 'id', 'caption_current'),
                'options'       => ['placeholder' => Yii::t('app', 'Введите поисковый запрос')],
                'theme'         => 'default',
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>
