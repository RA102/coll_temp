<?php

use common\models\RequiredDisciplines;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Планируемый объем нагрузки на группы по дисциплинам ';
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
    <?= Html::a('Добавить', ['create-required'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="required-index skin-white">
	<div class="card-body">
		<table class="table table-bordered table-striped">
			<tr>
				<th>Группа</th>
				<th>Дисциплина</th>
				<th>Кол-во часов в 1 семестре</th>
				<th>Переподаватель</th>
				<th>Кол-во часов в 2 семестре</th>
				<th>Переподаватель</th>
				<th>Всего часов за курс</th>
				<th>Кол-во провед. часов</th>
				<th>Кол-во непровед. часов</th>
			</tr>
			<?php foreach ($required as $req):?>
				<tr>
					<td><?=$req->group->caption_current?></td>
					<td><?=$req->institutionDiscipline->caption_current?></td>
					<td><?=$req->totalHours(1)?></td>
					<td><?=$req->teacherCourse->person->fullName?></td>
					<td><?=$req->totalHours(2)?></td>
					<td><?=$req->teacherCourse->person->fullName?></td>
					<td><?=$req->totalHours(3)?></td>
					<td></td>
					<td></td>
				</tr>
			<?php endforeach;?>
		</table>
	</div>
</div>