<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ReceptionGroup */

$this->title = Yii::t('app', 'View');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => ['index', 'commission_id' => $model->commission_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div style="position: relative;">
    <h1 class="pull-left"><?=$this->title?></h1>
    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'pull-right btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger pull-right',
        'style' => 'margin-right: 10px;',
        'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ]) ?>
</div>
<div class="clearfix"></div>

<div class="reception-group-index skin-white">
    <div class="card-body">
        <div class="reception-group-view">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'caption_current',
                    'language',
                    'speciality_id',
                    'education_form',
                    'budget_places',
                    'commercial_places',
                    'create_ts',
                    'update_ts',
                    'delete_ts',
                ],
            ]) ?>

        </div>
    </div>
</div>