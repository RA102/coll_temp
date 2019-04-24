<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reception Exams');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reception-exam-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Reception Exam'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'commission_id',
            'institution_discipline_id',
            'teacher_id',
            'date_ts',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
