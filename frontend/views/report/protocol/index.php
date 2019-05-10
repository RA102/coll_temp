<?php

use common\models\reception\AdmissionProtocol;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $commission \common\models\reception\Commission */
/* @var $searchModel frontend\search\AdmissionProtocolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Protocols');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commissions'), 'url' => ['/commission/index']];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Commission'),
    'url'   => ['/commission/view', 'id' => $commission->id]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Reports'),
    'url'   => ['/report/index', 'commission_id' => $commission->id]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?= $this->title ?> (<?= $dataProvider->totalCount ?>)</h1>
    <?= Html::a(Yii::t('app', 'Create'), Url::current(['create']), ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="card">
    <div class="card-body">

        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],

                'number',
                'completion_date:date',
                'status',
                'create_ts:date',

                [
                    'class'      => 'yii\grid\ActionColumn',
                    'urlCreator' => function (
                        string $action,
                        AdmissionProtocol $admissionProtocol
                    ) {
                        return Url::current([
                            $action,
                            'commission_id' => $admissionProtocol->commission_id,
                            'id'            => $admissionProtocol->id
                        ]);
                    }
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>