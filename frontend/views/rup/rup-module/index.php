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
<?php //TODO Исправлю это говно чуть попопзже(Так делать неправильно)
$blockname=RupBlock::findOne($_GET['block_id']); ?>

    <h1><?= Html::encode($this->title) ?> блока <?php echo "\"".$blockname->code."-".$blockname->name."\"";  ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php
        Modal::begin([
            'header' => '<h2>Добавить модуль</h2>',
            'size'=>'modal-sm',
            'toggleButton' => ['label' => 'Добавить модуль','class'=>'btn btn-success','style'=>['margin-top'=>'5px;']],
        ]);

        echo $this->renderAjax('/rup/rup-module/_form',['model'=> $Model=new RupModule()]);

        Modal::end();


        ?>
        <?php
        Modal::begin([
            'header' => '<h2>Добавить модуль из шаблона</h2>',
            'size'=>'modal-sm',
            'toggleButton' => ['label' => 'Добавить модуль из шаблона','class'=>'btn btn-success','style'=>['margin-top'=>'5px;']],
        ]);

        echo $this->renderAjax('/rup/rup-module/_formTemplate',['model'=> $Model=new RupModule()]);

        Modal::end();


        ?>
<!--        <button moduleId="--><?php //echo $module_ID?><!--" title='Добавить' style='' data-target="#addModalModule" data-toggle="modal" class='btn btn-success edit_qual addQualModuleButton' idd="--><?//= $al['id'] ?><!--">-->
<!--            <h7>Добавить дисциплину без модуля<i class='fas fa-edit'></i></h7>-->
<!--        </button>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-bordered table-striped table-hover',
        ],
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
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
//            ['attribute'=>'123','value'=>function(){
//
//                return '<button moduleId='.$model->id."' title='Добавить' style='margin-left:10%;'
//                data-target='#addModalModule' data-toggle='modal'
//                class='btn btn-success edit_qual addQualModuleButton' idd=".$model->id.">
//                <h7>Добавить</h7>
//            </button>";
//            }],
            [
                    'attribute'=>'123',
                'label' => 'Добавить',
                'format' => 'raw',
                'value' => function($model){return Html::button('Добавить',[
                        'class' => 'btn btn-success btn-xs edit_qual addQualModuleButton',
                        'moduleId'=>$model->id,
                        'idd'=>$model->id,
                        'data-target'=>'#addModalModule',
                        'data-toggle'=>'modal']);},
            ]

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
