<?php

use common\models\Course;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \frontend\search\CourseSearch */

$this->title = Yii::t('app', 'Courses');
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?= $this->title ?></h1>
    <?= Html::a('Добавить', ['create'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="group-index skin-white">

    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                /*[
                    'attribute' => 'caption',
                    'value' => function (Course $model) {
                        return $model->caption_current;
                    },
                ],*/
                [
                    'attribute' => 'institution_discipline_id',
                    'value' => function (Course $model) {
                        return $model->institutionDiscipline->caption_current;
                    },
                ],
                [
                    'attribute' => 'classes',
                    'filter' =>  null, //Html::activeDropDownList($searchModel, 'classes', ArrayHelper::map(Course::find()->all(), 'classes', 'classes'), ['prompt' => '', 'class' => 'form-control form-control-sm']),
                    'value' => function (Course $model) {
                        return implode(', ', $model->classes);
                    }
                ],
                //'create_ts',
                //'update_ts',
                //'delete_ts',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
