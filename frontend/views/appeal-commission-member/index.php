<?php

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commissions'), 'url' => ['/commission']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Current Commission'), 'url' => ['/commission/current']];
$this->title = Yii::t('app', 'Commission members');
$this->params['breadcrumbs'][] = $this->title;

use yii\grid\GridView;
use yii\helpers\Html; ?>
<div style="position: relative;">
    <h1><?=$this->title?></h1>
    <?= Html::a('Добавить', ['create', 'id' => $search->appeal_commission_id], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="group-index skin-white">
    <div class="card-body">
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $search,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'member_id',
            'value' => function (\common\models\link\AppealCommissionMemberLink $model) {
                return $model->member->getFullName();
            },
            'filter' => false
        ],
        [
            'attribute' => 'role',
            'value' => function (\common\models\link\AppealCommissionMemberLink $model) {
                return $model->getRoleValue();
            },
            'filter' => \common\helpers\CommissionMemberHelper::getRoleList(),
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
        ],
    ],
]); ?>
    </div>
</div>
