<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $teacher->fullName;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Работа с инженерно-педагогическими кадрами'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планируемый объем нагрузки на преподавателя по практикам'), 'url' => ['practice-teacher']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="required-index skin-white">
	<div class="card-body">
		<table class="table table-bordered table-striped">
			<tr>
				<!-- <th>Переподаватель</th> -->
				<th>Практика, ДП</th>
				<th>Группа</th>
				<th>Кол-во часов в 1 семестре</th>
				<th>Кол-во часов в 2 семестре</th>
				<th>Всего часов за курс</th>
			</tr>
			<?php foreach ($data as $model):?>
				<tr>
					<!-- <td><?=$teacher->fullName?></td> -->
					<td><?=$model->practice->caption_current?></td>
					<td><?=$model->group->caption_current?></td>
					<td><?=$model->hours[1]?></td>
					<td><?=$model->hours[2]?></td>
					<td><?=$model->forYear()?></td>
				</tr>
			<?php endforeach;?>
		</table>
	</div>
</div>