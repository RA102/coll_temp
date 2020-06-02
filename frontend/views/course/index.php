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
<!--
<?php /*echo "<pre>";
var_dump(ArrayHelper::getColumn(Course::find()->all(), 'classes'));
echo "</pre>"; */?>

-->

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
                    'filter' => Html::activeDropDownList($searchModel, 'institution_discipline_id', ArrayHelper::map(Course::find()->all(), 'institution_discipline_id', function($model){ return $model->institutionDiscipline->caption_current; }), ['prompt' => '', 'class' => 'form-control form-control-sm']),
                    'value' => function (Course $model) {
                        return $model->institutionDiscipline->caption_current;
                    },
                ],
                [
                    'attribute' => 'classes',
                    'filter' => Html::dropDownList('classes', ArrayHelper::getColumn(Course::find()->all(), 'classes')),
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
