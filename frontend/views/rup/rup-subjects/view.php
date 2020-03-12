<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupSubjects */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Rup Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="rup-subjects-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_sub_block',
            'id_block',
            'exam',
            'control_work',
            'offset',
            'time:datetime',
            'teory_time:datetime',
            'lab_time:datetime',
            'production_practice_time:datetime',
            'one_sem_time:datetime',
            'two_sem_time:datetime',
            'three_sem_time:datetime',
            'four_sem_time:datetime',
            'five_sem_time:datetime',
            'six_sem_time:datetime',
            'seven_sem_time:datetime',
            'eight_sem_time:datetime',
        ],
    ]) ?>

</div>
