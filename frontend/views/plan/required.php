<?php

use common\models\TeacherCourse;
use common\models\organization\Group;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Обязательные дисциплины';
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
    <?= Html::a('Добавить', ['create-required'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="required-index skin-white">
	<div class="card-body">
		<?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'discipline_id',
                    'value' => function (TeacherCourse $model) {
                        return $model->getDisciplineName();
                    },
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
                    'attribute' => 'teacher_id',
                    'value' => function (TeacherCourse $model) {
                        return $model->person->getFullname();
                    },
                ],

                [
                	'class' => 'yii\grid\ActionColumn',
                	'urlCreator' => function ($action, $model, $key, $index) {
		            if ($action === 'view') {
		                $url ='view-required?teacher_course_id='.$model->id;
		                return $url;
		            }
		            if ($action === 'update') {
		                $url ='update-required?teacher_course_id='.$model->id;
		                return $url;
		            }
		            if ($action === 'delete') {
		                $url ='delete-required?teacher_course_id='.$model->id;
		                return $url;
		            }
		          }
                ],
            ],
        ]); ?>
	</div>
</div>