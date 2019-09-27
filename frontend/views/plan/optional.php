<?php

use common\models\OptionalDisciplines;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Дисциплины по выбору';
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
    <?= Html::a('Добавить', ['create-optional'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="optional-index skin-white">
	<div class="card-body">
		<?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'discipline_id',
                    'value' => function (OptionalDisciplines $model) {
                        return $model->institutionDiscipline->caption_current;
                    },
                ],
                [
                    'attribute' => 'teacher_id',
                    'value' => function (OptionalDisciplines $model) {
                        return $model->teacher->getFullname();
                    },
                ],

                [
                	'class' => 'yii\grid\ActionColumn',
                	'urlCreator' => function ($action, $model, $key, $index) {
		            if ($action === 'view') {
		                $url ='view-optional?id='.$model->id;
		                return $url;
		            }
		            if ($action === 'update') {
		                $url ='update-optional?id='.$model->id;
		                return $url;
		            }
		            if ($action === 'delete') {
		                $url ='delete-optional?id='.$model->id;
		                return $url;
		            }
		          }
                ],
            ],
        ]); ?>
	</div>
</div>