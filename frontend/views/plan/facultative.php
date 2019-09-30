<?php

use common\models\Facultative;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Факультативные занятия';
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
    <?= Html::a('Добавить', ['create-facultative'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="optional-index skin-white">
	<div class="card-body">
		<?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'teacher_course_id',
                    'value' => function (Facultative $model) {
                        return $model->teacherCourse->disciplineName;
                    },
                ],
                [
                    'attribute' => 'group_id',
                    'value' => function (Facultative $model) {
                        return $model->group->caption_current;
                    },
                ],
                [
                    'attribute' => 'teacher_id',
                    'value' => function (Facultative $model) {
                        return $model->teacher->getFullname();
                    },
                ],

                [
                	'class' => 'yii\grid\ActionColumn',
                	'urlCreator' => function ($action, $model, $key, $index) {
		            if ($action === 'view') {
		                $url ='view-facultative?id='.$model->id;
		                return $url;
		            }
		            if ($action === 'update') {
		                $url ='update-facultative?id='.$model->id;
		                return $url;
		            }
		            if ($action === 'delete') {
		                $url ='delete-facultative?id='.$model->id;
		                return $url;
		            }
		          }
                ],
            ],
        ]); ?>
	</div>
</div>