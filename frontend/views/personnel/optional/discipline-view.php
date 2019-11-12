<?php

use common\models\RequiredDisciplines;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $discipline->caption_current;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Работа с инженерно-педагогическими кадрами'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планируемый объем нагрузки по дисциплинам (по выбору)'), 'url' => ['optional-discipline']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="required-index skin-white">
	<div class="card-body">
		<table class="table table-bordered table-striped">
			<tr>
				<!-- <th>Дисциплина</th> -->
				<th>Кол-во обучающихся</th>
				<th>Кол-во часов в 1 семестре</th>
				<th>Переподаватель</th>
				<th>Кол-во часов в 2 семестре</th>
				<th>Переподаватель</th>
				<th>Всего часов за курс</th>
			</tr>
			<?php foreach ($data as $model):?>
				<tr>
					<!-- <td><?=$model->institutionDiscipline->caption_current?></td> -->
					<td><?=$model->countStudents()?></td>
					<td><?=$model->totalHours(1)?></td>
					<td><?=$model->teacher->fullName?></td>
					<td><?=$model->totalHours(2)?></td>
					<td><?=$model->teacher->fullName?></td>
					<td><?=$model->totalHours(3)?></td>
				</tr>
			<?php endforeach;?>
		</table>
	</div>
</div>