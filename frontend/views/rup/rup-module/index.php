<?php

use frontend\models\rup\RupBlock;
use frontend\models\rup\RupQualifications;
use frontend\models\rup\RupModule;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\rup\RupModuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Модули';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rup-sub-block-index">
<?php $blockname=RupBlock::findOne($_GET['block_id']); ?>
    <h1><?= Html::encode($this->title) ?> блока <?php echo "\"".$blockname->name."\"";  ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
        Modal::begin([
            'header' => '<h2>Добавить модуль</h2>',
            'size'=>'modal-sm',
            'toggleButton' => ['label' => 'Добавить модуль','class'=>'btn btn-success','style'=>['margin-top'=>'5px;']],
        ]);

        echo $this->renderAjax('/rup/rup-module/_form',['model'=> $Model=new RupModule()]);

        Modal::end();


        ?>
<!--        <button moduleId="--><?php //echo $module_ID?><!--" title='Добавить' style='' data-target="#addModalModule" data-toggle="modal" class='btn btn-success edit_qual addQualModuleButton' idd="--><?//= $al['id'] ?><!--">-->
<!--            <h7>Добавить дисциплину без модуля<i class='fas fa-edit'></i></h7>-->
<!--        </button>-->
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'code',
            ['attribute'=>'name'],
            'time',
            //['attribute'=>'block.name','header' => 'Профиль'],
            ['attribute'=>'timemodulededucted','header' => 'Не распределено'],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                // uncomment below and comment detail if you need to render via ajax
                'detailUrl'=>Url::to(['/rup/rup-module/subjects-detail']),
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
