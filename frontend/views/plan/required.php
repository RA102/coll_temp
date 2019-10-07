<?php

use common\models\RequiredDisciplines;
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
                    'value' => function (RequiredDisciplines $model) {
                        return $model->institutionDiscipline->caption_current;
                    },
                ],
                [
                'attribute' => 'group_id',
                    'value' => function (RequiredDisciplines $model) {
                        return $model->group->caption_current;
                    }
                ],
                [
                    'attribute' => 'teacher_id',
                    'value' => function (RequiredDisciplines $model) {
                        return $model->teacher->fullName;
                    },
                ],

                [
                	'class' => 'yii\grid\ActionColumn',
                	'urlCreator' => function ($action, $model, $key, $index) {
		            if ($action === 'view') {
		                $url ='view-required?id='.$model->id;
		                return $url;
		            }
		            if ($action === 'update') {
		                $url ='update-required?id='.$model->id;
		                return $url;
		            }
		            if ($action === 'delete') {
		                $url ='delete-required?id='.$model->id;
		                return $url;
		            }
		          }
                ],
            ],
        ]); ?>
	</div>
</div>