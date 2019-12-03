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
                        return $model->speciality->getCaptionWithCode() ?? null;
                    },
                ],
                'class',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{generate}',
                    'buttons' => [
                        'generate' => function ($url, \common\models\organization\Group $model) use ($template) {
                        	if (in_array($template, ['04', '09'])) {
	                            return Html::a('<span class="glyphicon glyphicon-share-alt"></span>',
                                	['export-group-order', 'group_id' => $model->id, 'template' => $template]
                            	);
	                        }
                            else {
                            	return Html::a('<span class="glyphicon glyphicon-share-alt"></span>',
                                	['group-order', 'group_id' => $model->id, 'template' => $template]
                            	);
                            }
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>
