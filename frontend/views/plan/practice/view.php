<?php

use common\models\PracticePlan;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDiscipline */

$this->title = $model->practice->caption_current;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планирование учебного процесса'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Практика'), 'url' => ['practice']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="view-required">
	<div class="card-head">
		<!-- <p>
		            <?= Html::a(Yii::t('app', 'Delete'), ['delete-practice', 'id' => $model->id], [
		                'class' => 'btn btn-danger',
		                'data' => [
		                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
		                    'method' => 'post',
		                ],
		            ]) ?>
		        </p> -->

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'caption',
                    'value' => function (PracticePlan $model) {
                        return $model->practice->caption_current;
                    },
                    'label' => 'Название'
                ],
                [
                    'attribute' => 'group_id',
                    'value' => function (PracticePlan $model) {
                        return $model->group->caption_current;
                    },
                ],
            ],
        ]) ?>
	</div>
	<div class="card-body skin-white">
		<h2>Планирумое кол-во часов</h2>
        <?= Html::a(Yii::t('app', 'Update'), ['update-practice', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<table class="table table-bordered">
			<tr>
				<th></th>
				<th>Семестр I</th>
				<th>Семестр II</th>
				<th>За год</th>
			</tr>
			<tr>
				<th>Лекции (ч)</th>
				<td><?=$model->hours[1]?></td>
				<td><?=$model->hours[2]?></td>
				<td><?=$model->forYear('lections_hours')?></td>
			</tr>
			<tr>
				<th>Преподаватель</th>
				<td>
					<?php if($model->teacher[1] !== null):?> 
						<?=$model->getTeacher($model->teacher[1])->getFullName()?>
					<?php endif;?>
				</td>
				<td>
					<?php if($model->teacher[2] !== ""):?>
						<?=$model->getTeacher($model->teacher[2])->getFullName()?>
					<?php endif;?>
				</td>
				<td></td>
			</tr>
		</table>

	</div>
</div>