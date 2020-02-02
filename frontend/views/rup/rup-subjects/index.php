<?php

use frontend\models\rup\RupBlock;
use frontend\models\rup\RupSubBlock;
use frontend\models\rup\RupSubjects;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
//use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\rup\RupSubjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rup Subjects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-body skin-white">
<div class="rup-subjects-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Rup Subjects', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
                'label'=>'ИНД',
                'width' => '150px',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->block->name;
                },
                'filterType' => GridView::FILTER_CHECKBOX,
                'filter' => ArrayHelper::map(RupBlock::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Any supplier'],
                'group' => true,  // enable grouping
            ],
            [
                'attribute' => 'id_sub_block',
                'width' => '150px',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->subBlock->name;
                },
                'filterType' => GridView::FILTER_CHECKBOX,
                'filter' => ArrayHelper::map(RupSubBlock::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Any supplier'],
                'group' => true,  // enable grouping
            ],
                                [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                // uncomment below and comment detail if you need to render via ajax
                 'detailUrl'=>Url::to(['/site/book-details']),
//                'detail' => function ($model, $key, $index, $column) {
//                    return Yii::$app->controller->renderPartial('/rup/rup-subjects/view', ['model' => $model]);
//                },
                'headerOptions' => ['class' => 'kartik-sheet-style'] ,
                'expandOneOnly' => true
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

            'id',
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
    <?php;?>
</div>
</div>