<?php

use common\models\organization\Group;
use common\models\TeacherCourse;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TeacherCourse */
/* @var $course common\models\Course */

$this->title = $model->getFullname();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['course/index']];
$this->params['breadcrumbs'][] = ['label' => $model->course->caption_current, 'url' => ['course/view', 'id' => $model->course->id]];
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
                    return $model->course->caption_current;
                }
            ],
            [
                'attribute' => 'teacher_id',
                'value' => function (TeacherCourse $model) {
                    return $model->person->getFullName();
                }
            ],
            [
                'attribute' => 'groups',
                'value' => function (TeacherCourse $model) {
                    return implode(', ', array_map(function (Group $group) {
                        return $group->caption_current;
                    }, $model->groups));
                }
            ],
            [
                'attribute' => 'status',
                'value' => function (TeacherCourse $model) {
                    return $model->getStatus($model->status);
                }
            ],
            /*[
                'attribute' => 'type',
                'value' => function (TeacherCourse $model) {
                    return $model->getType($model->type);
                }
            ],*/
            'create_ts',
            'update_ts',
            //'delete_ts',
        ],
    ]) ?>

    </div>
</div>
