<?php

use common\models\Ktp;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'КТП';
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
    <?= Html::a('Добавить', ['create-ktp'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="required-index skin-white">
	<div class="card-body">
		<?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'group_id',
                    'value' => function (Ktp $model) {
                        return $model->group->caption_current;
                    },
                ],
                [
                    'attribute' => 'institution_discipline_id',
                    'value' => function (Ktp $model) {
                        return $model->institutionDiscipline->caption_current;
                    },
                ],
                [
                    'attribute' => 'teacher_id',
                    'value' => function (Ktp $model) {
                        return $model->teacher->getFullName();
                    },
                ],

                [
                	'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                	'urlCreator' => function ($action, $model, $key, $index) {
    		            if ($action === 'view') {
    		                $url ='ktp-view?id='.$model->id;
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