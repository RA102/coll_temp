<?php

use common\models\RequiredDisciplines;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $group->caption_current;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Работа с инженерно-педагогическими кадрами'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планируемый объем нагрузки на группы по факультативам'), 'url' => ['facultative-group']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="required-index skin-white">
	<div class="card-body">
		<table class="table table-bordered table-striped">
			<tr>
				<!-- <th>Группа</th> -->
				<th>Факультатив</th>
				<th>Кол-во часов в 1 семестре</th>
				<th>Переподаватель</th>
				<th>Кол-во часов в 2 семестре</th>
				<th>Переподаватель</th>
				<th>Всего часов за курс</th>
			</tr>
			<?php foreach ($facultative as $fac):?>
				<tr>
					<!-- <td><?=$fac->group->caption_current?></td> -->
					<td><?=$fac->teacherCourse->disciplineName?></td>
					<td><?=$fac->hours[1]?></td>
					<td><?=$fac->teacher->fullName?></td>
					<td><?=$fac->hours[2]?></td>
					<td><?=$fac->teacher->fullName?></td>
					<td><?=$fac->forYear()?></td>
				</tr>
			<?php endforeach;?>
		</table>
	</div>
</div>