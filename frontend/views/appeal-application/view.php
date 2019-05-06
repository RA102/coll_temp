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
    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="card">
    <div class="card-body">
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