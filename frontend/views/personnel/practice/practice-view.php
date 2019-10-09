<?php

use common\models\RequiredDisciplines;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Планируемый объем нагрузки по практикам';
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="required-index skin-white">
	<div class="card-body">
		<table class="table table-bordered table-striped">
			<tr>
				<th>Практика, ДП</th>
				<th>Группа</th>
				<th>Кол-во часов в 1 семестре</th>
				<th>Переподаватель</th>
				<th>Кол-во часов в 2 семестре</th>
				<th>Переподаватель</th>
				<th>Всего часов за курс</th>
			</tr>
			<?php foreach ($data as $model):?>
				<tr>
					<td><?=$model->practice->caption_current?></td>
					<td><?=$model->group->caption_current?></td>
					<td><?=$model->hours[1]?></td>
					<td><?=$model->getTeacher($model->teacher[1])->fullName?></td>
					<td><?=$model->hours[2]?></td>
					<td><?=$model->getTeacher($model->teacher[2])->fullName?></td>
					<td><?=$model->forYear()?></td>
				</tr>
			<?php endforeach;?>
		</table>
	</div>
</div>