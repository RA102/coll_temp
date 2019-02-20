<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\search\LessonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lessons');
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="position: relative;">
    <h1><?= $this->title ?></h1>
    <?= Html::a('Добавить', ['create'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="lesson-index skin-white">

    <div class="card-body">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'teacher_course_id',
                'teacher_id',
                'date_ts',
                'duration',
                //'create_ts',
                //'update_ts',
                //'delete_ts',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
