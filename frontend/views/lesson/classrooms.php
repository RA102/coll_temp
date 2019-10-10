<?php

use common\models\organization\Classroom;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\search\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Аудитории');
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="group-index skin-white">
    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'number',
                    'value' => function (Classroom $model) {
                        return Html::a($model->number, [
                            '/schedule/classroom-card',
                            'classroom_id' => $model->id,
                        ]);
                    },
                    'format' => 'html',
                ],
            ],
        ]); ?>

    </div>
</div>
