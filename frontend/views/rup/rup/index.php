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
<div class="card-body skin-white">
<div class="rup-roots-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить РУП', ['create'], ['class' => 'btn btn-success']) ?>
        <!-- <?= Html::a('Открыть', ['create'], ['class' => 'btn btn-info']) ?>  -->
        <!-- <?= Html::a('Сохранить в файл', ['create'], ['class' => 'btn btn-info', 'disabled' => true]) ?> -->
        
        <!-- <?= Html::a('Экспорт в Excel', ['create'], ['class' => 'btn btn-info', 'disabled' => true]) ?> -->
        <!-- <?= Html::a('Сделать копию', ['create'], ['class' => 'btn btn-info', 'disabled' => true]) ?> -->

    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'captionRu',
//            'rup_id',
            'rup_year',
            ['attribute'=>'status',
            'value'=>function($model){
                if($model->status==1){
                    return "Открыт для редактирования";
                }
                elseif ($model->status==0){
                    return "Закрыт для редактирования";
                }
                            }],
//            'create_ts',
//            'delete_ts',
            //'lastopen_ts',
            //'lastclose_ts',
            //'create_userid',
            //'delete_userid',
            //'lastopen_userid',
            //'lastclose_userid',

            //'captionKz',
            //'lang',
            //'profile_code',
            //'spec_code',
            //'edu_form',

            ['class' => 'yii\grid\ActionColumn',
                'buttons'=>[
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('app', 'lead-view'),
                            ]);
                        },

                        'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('app', 'lead-update'),
                                ]);

                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('app', 'lead-delete'),
                            ]);
                        }

                    ],
                ],
                'visibleButtons'=>[
                     'update'=>function ($model, $key, $index) { if($model->status==0){return false;}else{return true;}},
                     'view'=>function ($model, $key, $index) { if($model->status==1){return false;}else{return true;}},
                     'delete'=>function ($model, $key, $index) { if($model->status==0){return false;}else{return true;}},

                ]
                ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    <?php
    ?>
</div>
</div>