<?php

use common\models\TeacherCourse;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TeacherCourse */

$this->title = $model->course->caption;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="group-view skin-white">

    <div class="card-body">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id, 'course_id' => $model->course_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id, 'course_id' => $model->course_id], [
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
                'attribute' => 'course_id',
                'value' => function (TeacherCourse $model) {
                    return $model->course->caption;
                }
            ],
            [
                'attribute' => 'teacher_id',
                'value' => function (TeacherCourse $model) {
                    return $model->person->getFullName();
                }
            ],
            'type',
            'start_ts',
            'end_ts',
            'create_ts',
            'update_ts',
            'delete_ts',
        ],
    ]) ?>

    </div>
</div>
