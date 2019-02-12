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
    <?= Html::a('Добавить', ['create'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="group-index skin-white">

    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
    //            'caption',
                'language',
                'speciality_id',
                'max_class',
                //'class',
                //'education_form',
                //'education_pay_form',
                //'institution_id',
                //'parent_id',
                //'type',
                //'rating_system_id',
                //'based_classes',
                //'class_change_history',
                //'properties',
                //'is_deleted:boolean',
                //'start_ts',
                //'create_ts',
                //'update_ts',
                //'delete_ts',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
