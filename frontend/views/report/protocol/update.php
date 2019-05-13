<?php

/* @var $this yii\web\View */
/* @var $admissionProtocol \common\models\reception\AdmissionProtocol */
/* @var $admissionProtocolForm \frontend\models\forms\AdmissionProtocolForm */
/* @var $commission \common\models\reception\Commission */

$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commissions'), 'url' => ['/commission/index']];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Commission'),
    'url'   => ['/commission/view', 'id' => $commission->id]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Protocols'),
    'url'   => ['index', 'commission_id' => $commission->id]
];
$this->params['breadcrumbs'][] = [
    'label' => $admissionProtocol->number,
    'url'   => [
        'view',
        'commission_id' => $commission->id,
        'id'            => $admissionProtocol->id
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="admission-protocol-update">

    <h1><?= $this->title ?></h1>
    <?php $this->beginBlock('content') ?>
    <div class="admission-protocol-create">
        <?= $this->render('_form', [
            'admissionProtocolForm' => $admissionProtocolForm,
            'commissionMembers'     => $commission->members
        ]) ?>
    </div>
    <?php $this->endBlock() ?>
    <?= $this->render('_layout') ?>

</div>
