<?php

use common\models\TeacherCourse;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Дисциплины по выбору';
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="optional-index skin-white">
	<div class="card-body">
		<?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'discipline_id',
                    'value' => function (TeacherCourse $model) {
                        return $model->disciplineName;
                    },
                    'label' => 'Дисциплина'
                ],
                [
                    'attribute' => 'teacher_id',
                    'value' => function (TeacherCourse $model) {
                        return $model->person->getFullname();
                    },
                ],

                [
                	'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update}',
                	'urlCreator' => function ($action, $model, $key, $index) {
    		            if ($action === 'view') {
    		                $url ='view-optional?teacher_course_id='.$model->id;
    		                return $url;
    		            }
    		            if ($action === 'update') {
    		                $url ='edit-optional?teacher_course_id='.$model->id;
    		                return $url;
    		            }
		            }
                ],
            ],
        ]); ?>
	</div>
</div>