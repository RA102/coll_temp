<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $admissionProtocol common\models\reception\AdmissionProtocol */
/* @var $commission common\models\reception\Commission */

$this->title = Yii::t('app', 'Protocol №{number}', ['number' => $admissionProtocol->number]);

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
$this->params['breadcrumbs'][] = $admissionProtocol->number;
?>
<div style="position: relative;">
    <h1><?= $this->title ?></h1>
</div>

<div class="card">
    <div class="card-body">

        <p>
            <?php
            if ($admissionProtocol->isCreated()) {
                echo Html::a(Yii::t('app', 'Update'),
                    ['update', 'id' => $admissionProtocol->id, 'commission_id' => $commission->id],
                    ['class' => 'btn btn-primary']);
            }
            ?>
            <?= Html::a(Yii::t('app', 'Print'),
                ['update', 'id' => $admissionProtocol->id, 'commission_id' => $commission->id],
                ['class' => 'btn btn-primary']) ?>
            <?php if ($admissionProtocol->isCreated()) {
                echo Html::a(Yii::t('app', 'Close'),
                    ['close', 'id' => $admissionProtocol->id, 'commission_id' => $commission->id], [
                        'class' => 'btn btn-danger pull-right',
                        'data'  => [
                            'confirm' => Yii::t('app', 'Are you sure you want to close this item?'),
                            'method'  => 'post',
                        ],
                    ]);
            } ?>
            <?php if (!$admissionProtocol->isDeleted()) {
                echo Html::a(Yii::t('app', 'Delete'),
                    ['delete', 'id' => $admissionProtocol->id, 'commission_id' => $commission->id], [
                        'class' => 'btn btn-danger pull-right',
                        'style' => 'margin-right: 4px',
                        'data'  => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method'  => 'post',
                        ],
                    ]);
            } ?>
        </p>

        <?= DetailView::widget([
            'model'      => $admissionProtocol,
            'attributes' => [
                'completion_date',
                [
                    'attribute' => 'status',
                    'value'     => $admissionProtocol->getStatusLabel()
                ],
                'create_ts:datetime',
            ],
        ]) ?>

        <hr>

        <h4>Члены комиссии</h4>
        <?= \yii\grid\GridView::widget([
            'summary'      => false,
            'showHeader'   => false,
            'dataProvider' => new \yii\data\ArrayDataProvider([
                'models' => $admissionProtocol->getCommissionMemberLinks()
            ]),
            'columns'      => [
                'member.fullName'
            ]
        ]) ?>

        <hr>

        <h4>Повестка дня</h4>
        <table class="table table-bordered table-striped">
            <tbody>
            <?php foreach ($admissionProtocol->agendas as $agenda) { ?>
                <tr>
                    <td><?= $agenda ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <h4>Рассмотрели</h4>

        <?= Html::a(Yii::t('app', 'Add'),
            Url::current(['add-issue', 'id' => $admissionProtocol->id]),
            ['class' => 'btn btn-primary', 'style' => 'margin-bottom: 10px;']); ?>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>№</th>
                <th><?= Yii::t('app', 'Listened') ?></th>
                <th><?= Yii::t('app', 'Speakers') ?></th>
                <th><?= Yii::t('app', 'Decree') ?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($admissionProtocol->issues as $key => $issue) { ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= sizeof($issue['listeners']) ?></td>
                    <td><?= sizeof($issue['speakers']) ?></td>
                    <td><?= $issue['decree'] ?></td>
                    <td>
                        <?= Html::a("<icon class='fa fa-trash'></icon>",
                            [
                                'delete-issue',
                                'id'            => $admissionProtocol->id,
                                'commission_id' => $commission->id,
                                'key'           => $key
                            ], [
                                'class' => 'btn btn-danger pull-right',
                                'data'  => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method'  => 'post',
                                ],
                            ]); ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
