<?php

use common\models\TeacherCourse;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Факультативные занятия';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планирование учебного процесса'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
    <!-- <?= Html::a('Добавить', ['create-facultative'], ['class' => 'title-action btn btn-primary']) ?> -->
</div>

<div class="optional-index skin-white">
	<div class="card-body">
		<?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'teacher_course_id',
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
                    'template' => '{view}',
                	'urlCreator' => function ($action, $model, $key, $index) {
		            if ($action === 'view') {
		                $url ='view-facultative-groups?teacher_course_id='.$model->id;
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