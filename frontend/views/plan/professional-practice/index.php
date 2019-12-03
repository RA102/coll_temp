<?php

use common\models\ProfessionalPracticePlan;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Профессиональная практика';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планирование учебного процесса'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
    <?= Html::a('Добавить', ['edit-professional-practice'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="optional-index skin-white">
	<div class="card-body">
		<?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'group_id',
                    'value' => function (ProfessionalPracticePlan $model) {
                        return $model->group->caption_current;
                    },
                ],

                [
                    'attribute' => 'type',
                    'value' => function (ProfessionalPracticePlan $model) {
                        return $model->practice->type();
                    },
                ],

                [
                    'attribute' => 'weeks',
                    'value' => function (ProfessionalPracticePlan $model) {
                        return $model->weeks['first'] . ' - ' . $model->weeks['last'];
                    },
                ],

                [
                	'class' => 'yii\grid\ActionColumn',
                	'template' => '{update} {delete}',
                	'urlCreator' => function ($action, $model, $key, $index) {
		            if ($action === 'view') {
		                $url ='view-professional-practice?id='.$model->id;
		                return $url;
		            }
		            if ($action === 'update') {
		                $url ='edit-professional-practice?id='.$model->id;
		                return $url;
		            }
		            if ($action === 'delete') {
		                $url ='delete-professional-practice?id='.$model->id;
		                return $url;
		            }
		          }
                ],
            ],
        ]); ?>
	</div>
</div>