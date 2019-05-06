<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\search\AppealApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Applications');
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
    <?= Html::a('Добавить', ['create', 'id' => $searchModel->appeal_commission_id], ['class' => 'title-action btn btn-primary']) ?>
</div>


<div class="group-index skin-white">
    <div class="card-body">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'entrant_id',
                    'value' => function (\common\models\reception\AppealApplication $model) {
                        return $model->entrant->getFullName();
                    },
                    'filter' => false
                ],
                'reason:ntext',
                [
                    'attribute' => 'status',
                    'value' => function (\common\models\reception\AppealApplication $model) {
                        return $model->getStatusValue();
                    },
                    'filter' => \common\helpers\AppealApplicationHelper::getStatusList()
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
