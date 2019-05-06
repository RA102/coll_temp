<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealApplication */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Appeal Applications'), 'url' => ['index', 'commission_id' => $model->appeal_commission_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="card">
    <div class="card-body">

        <p>
            <?php if (!$model->isFinished()): ?>
                <?= Html::a(Yii::t('app', 'Accept'), ['accept', 'id' => $model->id], [
                    'class' => 'btn btn-success',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to accept this application?'),
                        'method' => 'post',
                    ],
                ]) ?>

            <?= Html::a(Yii::t('app', 'Reject'), ['reject', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to reject this application?'),
                    'method' => 'post',
                ],
            ]) ?>

                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>
        </p>

        <div class="appeal-application-view">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'entrant_id',
                        'value' => function (\common\models\reception\AppealApplication $model) {
                            return $model->entrant->getFullName();
                        },
                    ],
                    'reason:ntext',
                    [
                        'attribute' => 'status',
                        'value' => function (\common\models\reception\AppealApplication $model) {
                            return $model->getStatusValue();
                        },
                    ],
                    'create_ts',
                    'update_ts',
                ],
            ]) ?>

        </div>
    </div>
</div>