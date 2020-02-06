<?php

use frontend\models\rup\RupBlock;
use frontend\models\rup\RupModule;
use frontend\models\rup\RupSubjects;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\rup\RupSubjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary' => true,
        'pjax' => true,
        'striped' => true,
        'hover' => true,
        'panel' => ['type' => 'primary', 'heading' => 'РУПЫ'],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','options'=>['width'=>'10px']],
            [
                'attribute' => 'id_block',
                'width' => '150px',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->block->name;
                },
//                'filterType' => GridView::FILTER_SELECT2,
//                'filter' => ArrayHelper::map(RupBlock::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
//                'filterWidgetOptions' => [
//                    'pluginOptions' => ['allowClear' => true],
//                ],
                'filterInputOptions' => ['placeholder' => 'Any supplier'],
                'group' => true,  // enable grouping
            ],
            [
                'attribute' => 'id_sub_block',
                'width' => '150px',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->subBlock->name;
                },
//                'filterType' => GridView::FILTER_SELECT2,
//                'filter' => ArrayHelper::map(RupSubBlock::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
//                'filterWidgetOptions' => [
//                    'pluginOptions' => ['allowClear' => true],
//                ],
                'filterInputOptions' => ['placeholder' => 'Any supplier'],
                'group' => true,  // enable grouping
            ],


//            [
//                    'label'=>'Модуль',
//                'attribute' => 'sub-block.id',
//                'width' => '110px',
//                'value' => function ($model, $key, $index, $widget) {
//                    return $model->subBlock->name.":".$model->subBlock->id;
//                },
//                'filterType' => GridView::FILTER_SELECT2,
//                'filter' => ArrayHelper::map(RupSubBlock::find()->orderBy('id')->asArray()->all(), 'id', 'code'),
//                'filterWidgetOptions' => [
//                    'pluginOptions' => ['allowClear' => true],
//                ],
//                'filterInputOptions' => ['placeholder' => 'Any supplier'],
////                'group' => true,  // enable grouping
//            ],

//            'id',
//            'id_sub_block',
//            'id_block',
            'name',
//            'control_work',
//            'offset',
            'time',
            //'teory_time:datetime',
            //'lab_time:datetime',
            //'production_practice_time:datetime',
            //'one_sem_time:datetime',
            //'two_sem_time:datetime',
            //'three_sem_time:datetime',
            //'four_sem_time:datetime',
            //'five_sem_time:datetime',
            //'six_sem_time:datetime',
            //'seven_sem_time:datetime',
            //'eight_sem_time:datetime',
//            'notTime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>