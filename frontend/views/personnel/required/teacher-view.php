<?php

use common\models\RequiredDisciplines;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $teacher->fullName;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Работа с инженерно-педагогическими кадрами'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планируемый объем нагрузки на преподавателя по дисциплинам (обязательным)'), 'url' => ['required-teacher']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="required-index skin-white">
	<div class="card-body">
		<table class="table table-bordered table-striped">
			<tr>
				<th>Переподаватель</th>
				<th>Дисциплина</th>
				<th>Группа</th>
				<th>Кол-во часов в 1 семестре</th>
				<th>Кол-во часов в 2 семестре</th>
				<th>Всего часов за курс</th>
				<th>Кол-во провед. часов</th>
				<th>Кол-во непровед. часов</th>
			</tr>
			<?php foreach ($required as $req):?>
				<tr>
					<td><?=$req->teacherCourse->person->fullName?></td>
					<td><?=$req->institutionDiscipline->caption_current?></td>
					<td><?=$req->group->caption_current?></td>
					<td><?=$req->totalHours(1)?></td>
					<td><?=$req->totalHours(2)?></td>
					<td><?=$req->totalHours(3)?></td>
					<td></td>
					<td></td>
				</tr>
			<?php endforeach;?>
		</table>
	</div>
</div>