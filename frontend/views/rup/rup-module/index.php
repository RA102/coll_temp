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
            'size'=>'modal-lg',
            'toggleButton' => ['label' => 'Добавить модуль из шаблона','class'=>'btn btn-success','style'=>['margin-top'=>'5px;']],
        ]);

        echo $this->renderAjax('/rup/rup-module/_formTemplate',['model'=> $Model=new RupModule()]);

        Modal::end();


        ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-bordered table-striped table-hover',
        ],
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->id,'data-rup_id' => $model->rup_id,'data-timemodulededucted'=>$model->timemodulededucted,
                'data-code'=>$model->code,'data-name'=>$model->name,'data-time'=>$model->time,];
        },
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'code',
            'name',
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
            [
                'attribute' => '123',
                'label' => 'Добавить',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::button('Добавить', [
                        'class' => 'btn btn-success btn-xs edit_qual addQualModuleButton',
                        'moduleId' => $model->id,
                        'idd' => $model->id,
                        'data-target' => '#addModalModule',
                        'data-toggle' => 'modal']);
                },
            ],
            [
                'attribute' => 'Редактирование',
                'format' => 'raw',
                'contentOptions' => ['class' => 'abracadabra'],
                'value' => function ($model) {

                    return '<button title="Изменить" data-target="#editModalBlock" data-toggle="modal" style="margin-left:3%;" 
                    class="btn btn-success edit_qualBlock" qualeditbuttonid="'.$model->id.'"><h7><i class="fas fa-edit"></i></h7></button>'
                .'<button title="Удалить" style="margin-left:3%;" 
                    class="btn btn-danger deleteModuleButton" modelId="'.$model->id.'"><h7><i class="fas fa-trash"></i></h7></button>'.'</div>';
        
                },
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <script>
        $('.deleteModuleButton').on('click',function (e) {
            e.preventDefault();
            let moduleDeleteId=$(this).attr('modelid');
            if (confirm('Вы действительно хотите удалить?')) {
                $.ajax({
                    type: 'GET',
                    url: '/rup/rup-module/delete-module?id='+moduleDeleteId,
                    success: function(data){
                        location.reload();
                    }
                });
            }
            else{}


        });
    </script>
    <?php Pjax::end(); ?>
</div>
