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

//            'id',
            'code',
            'name',
            'time',
            ['attribute'=>'timemodulededucted',
            'pageSummary' => true,
                'label'=>'Не распределено'],

        ],
        'showPageSummary' => true
    ]); ?>
    <?php Pjax::end(); ?>
    <div class="moduleDetail">

    </div>
    <?php
$this->registerJs("

    $('td').click(function (e) {
        var id = $(this).closest('tr').data('rup_id');
        var block_Id = $(this).closest('tr').data('id');
        if(e.target == this)
            location.href = '" . Url::to(['/rup/rup/update']) . "?id=' + id+'&active=2&block_id='+block_Id;
    });

");?>
</div>
