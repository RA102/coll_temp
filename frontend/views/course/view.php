<?php

use common\models\Course;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Course */
/* @var $teacherCourseDataProvider yii\data\ActiveDataProvider */
/* @var $teacherCourseSearchModel frontend\search\TeacherCourseSearch */

$this->title = $model->discipline->caption;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="group-view skin-white">

    <div class="card-body">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'discipline_id',
                'value' => function (Course $model) {
                    return $model->discipline->caption;
                },
            ],
            'caption',
            [
                'attribute' => 'classes',
                'value' => function (Course $model) {
                    return implode(', ', $model->classes);
                }
            ],
            'create_ts',
            'update_ts',
            'delete_ts',
        ],
    ]) ?>

    <hr>

    <p>
        <?= Html::a(Yii::t('app', 'Create Teacher Course'), ['teacher-course/create', 'course_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $teacherCourseDataProvider,
        'filterModel' => $teacherCourseSearchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'course_id',
            'teacher_id',
            'type',
            'start_ts',
            //'end_ts',
            //'create_ts',
            //'update_ts',
            //'delete_ts',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
