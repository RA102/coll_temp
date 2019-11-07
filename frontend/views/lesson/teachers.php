<?php

use common\models\person\Employee;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\search\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Карты занятости преподавателей');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Расписание'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="group-index skin-white">
    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                [
                    'attribute' => 'fullname',
                    'value' => function (Employee $model) {
                        return Html::a($model->fullname, [
                            '/schedule/teacher-card',
                            'teacher_id' => $model->id,
                        ]);
                    },
                    'format' => 'html',
                    'label' => 'ФИО',
                ],
                //'person_type',
            ],
        ]); ?>

    </div>
</div>
