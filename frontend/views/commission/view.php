<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\reception\Commission */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<h1><?= Html::encode($model->caption_current) ?></h1>

<div class="card">
    <div class="card-body">

    <p>
        <?= Html::a(Yii::t('app', 'Close'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'caption_current',
            'from_date',
            'to_date',
            'order_number',
            'order_date',
            'exam_start_date',
            'exam_end_date',
            [
                'attribute' => 'status',
                'value' => function (\common\models\reception\Commission $model) {
                    return \common\helpers\CommissionHelper::getStatusList()[$model->status];
                }
            ],
        ],
    ]) ?>

    <p>
        <?= Html::a(Yii::t('app', 'Commission members'), ['/commission-member', 'commission_id' => $model->id], [
            'class' => 'btn btn-success',
        ]) ?>
    </p>

    </div>
</div>
