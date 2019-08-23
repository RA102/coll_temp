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
                            'lesson/schedule',
                            'group_id' => $model->id,
                        ]);
                    },
                    'format' => 'html',
                ],
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
                        return $model->speciality->getCaptionWithCode() ?? null;
                    },
                ],
                'class',
            ],
        ]); ?>
    </div>
</div>