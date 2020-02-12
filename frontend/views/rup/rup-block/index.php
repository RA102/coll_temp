<?php

use frontend\models\rup\RupBlock;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\rup\RupBlockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Блоки РУПа';
?>
<div class="rup-block-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
<?php         Modal::begin([
    'header' => '<h2>Добавить модуль</h2>',
    'size'=>'modal-sm',
    'toggleButton' => ['label' => 'Добавить блок','class'=>'btn btn-success','style'=>['margin-top'=>'5px;']],


]);

echo $this->renderAjax('/rup/rup-block/_form',['model'=> $Model=new RupBlock()]);

Modal::end(); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->id,'data-rup_id' => $model->rup_id];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'rup_id',
            'code',
            'name',
            'time',
            ['attribute'=>'timemodulededucted',
            'pageSummary' => true,
                'label'=>'Не распределено'],
            [
                'attribute' => 'Редактирование',
                'format' => 'raw',
                'contentOptions' => ['class' => 'abracadabra'],
                'value' => function ($model) {
                    return '<div>'.'<button title="Изменить" data-target="#editModal" data-toggle="modal" style="margin-left:3%;" 
                            class="btn btn-success edit_qual" qualeditbuttonid="2"><h7><i class="fas fa-edit"></i></h7></button>'
                            .'<button title="Удалить" style="margin-left:3%;" 
                            class="btn btn-danger deleteModelButton" modelId="'.$model->id.'"><h7><i class="fas fa-trash"></i></h7></button>'.'</div>';
                },
            ],

        ],

        'showPageSummary' => true
    ]); ?>
    <?php Pjax::end(); ?>
    <div class="moduleDetail">
        <script>
            $('.deleteModelButton').on('click',function () {
                $.ajax({url: "/rup/rup-block/delete-ajax",data:{'id':$(this).attr('modelid')}, success: function(result){
                        location.reload();
                    }});
            });
        </script>

    </div>
    <?php
$this->registerJs("
    $('td[class=w5][class!=kv-page-summary]').click(function (e) {
        var id = $(this).closest('tr').data('rup_id');
        var block_Id = $(this).closest('tr').data('id');
        if($(this).attr('class')=='w5 abracadabra'){
        
        }
        else if($(this).attr('class')!='w5 abracadabra')
        {
         location.href = '" . Url::to(['/rup/rup/update']) . "?id=' + id+'&active=2&block_id='+block_Id;
         
        }


    });
    



");?>
</div>
