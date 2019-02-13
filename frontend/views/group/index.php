<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\search\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Groups');
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
    <?= Html::a('Добавить', ['create'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="group-index skin-white">

    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'caption_current',
                [
                    'format'    => 'html',
                    'attribute' => 'language',
                    'value'     => function (\common\models\organization\Group $model) {
                        return $model->getLanguage();
                    },
                ],
                [
                    'format'    => 'html',
                    'attribute' => 'speciality_id',
                    'value'     => function (\common\models\organization\Group $model) {
                        return $model->speciality->caption_current;
                    },
                ],
                'class',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
