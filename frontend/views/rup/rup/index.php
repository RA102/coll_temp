<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\rup\RupRootsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'РУПы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rup-roots-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить РУП', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Открыть', ['create'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Сохранить в файл', ['create'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Экспорт в Excel', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Сделать копию', ['create'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'rup_id',
            'rup_year',
            'status',
//            'create_ts',
//            'delete_ts',
            //'lastopen_ts',
            //'lastclose_ts',
            //'create_userid',
            //'delete_userid',
            //'lastopen_userid',
            //'lastclose_userid',
            'captionRu',
            //'captionKz',
            //'lang',
            //'profile_code',
            //'spec_code',
            //'edu_form',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
