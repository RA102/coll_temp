<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealApplication */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Appeal Applications'), 'url' => ['index']];
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
                    'entrant_id',
                    'reason:ntext',
                    'status',
                    'create_ts',
                    'update_ts',
                ],
            ]) ?>

        </div>
    </div>
</div>