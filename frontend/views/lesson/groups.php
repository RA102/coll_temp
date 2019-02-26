<?php

use common\models\organization\Group;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\search\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lessons');
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="position: relative;">
    <h1><?= $this->title ?></h1>
    <?= Html::a('Добавить', ['create'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="lesson-index skin-white">

    <div class="card-body">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'caption_current',
                    'value' => function (Group $model) {
                        return Html::a($model->caption_current, [
                            'lesson/index',
                            'group_id' => $model->id,
                        ]);
                    },
                    'format' => 'html',
                ],
            ],
        ]); ?>
    </div>
</div>