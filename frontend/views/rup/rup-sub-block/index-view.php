<?php

use frontend\models\rup\RupQualifications;
use frontend\models\rup\RupSubBlock;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\rup\RupSubBlockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Модули';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rup-sub-block-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'code',
            ['attribute'=>'name'],
//            'block_id',
            ['attribute'=>'block.name','header' => 'Профиль'],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                // uncomment below and comment detail if you need to render via ajax
                'detailUrl'=>Url::to(['/rup/rup-sub-block/subjects-detail-view']),
//                'detail' => function ($model, $key, $index, $column) {
//                    return Yii::$app->controller->renderPartial('/rup/rup-subjects/view', ['model' => $model]);
//                },
                'headerOptions' => ['class' => 'kartik-sheet-style'] ,
                'expandOneOnly' => true,
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
