<?php

use common\models\Course;
use common\models\TeacherCourse;
use common\models\organization\Group;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Course */
/* @var $teacherCourseDataProvider yii\data\ActiveDataProvider */
/* @var $teacherCourseSearchModel frontend\search\TeacherCourseSearch */

$this->title = $model->institutionDiscipline->caption_current;
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
                'attribute' => 'institution_discipline_id',
                'value' => function (Course $model) {
                    return $model->institutionDiscipline->caption_current;
                },
            ],
            'caption_current', /** @see Course::$caption_current */
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
//        'filterModel' => $teacherCourseSearchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'teacher_id',
                'value' => function (TeacherCourse $model) {
                    return $model->person->getFullName();
                }
            ],
            [
                'attribute' => 'type',
                'value' => function (TeacherCourse $model) {
                    return $model->getType($model->type);
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
            'start_ts',
            'end_ts',
            //'create_ts',
            //'update_ts',
            //'delete_ts',

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, TeacherCourse $teacherCourse, $key, $index) {
                    return \yii\helpers\Url::to([
                        'teacher-course/' . $action,
                        'id' => $teacherCourse->id,
                        'course_id' => $teacherCourse->course_id,
                    ]);
                }
            ],
        ],
    ]); ?>

    </div>
</div>
