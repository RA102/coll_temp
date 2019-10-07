<?php

use yii\web\View;
?>

<h1>Журнал замен</h1>
<div class="card-body skin-white">
	<table class="table table-bordered table-striped">
		<tr>
			<th>Дата</th>
			<th>Преподаватель</th>
			<th>Причина пропуска урока</th>
			<th>Преподаватель, проводивший замену урока</th>
			<th>Количество замененных уроков</th>
			<th>Подпись учителя, проводившего замену урока</th>
		</tr>
		<?php foreach ($journals as $journal):?>
			<tr>
				<td><?=$journal->date_ts?></td>
				<td><?=$journal->teacherCourse->person->fullName?></td>
				<td><?=$journal->reason?></td>
				<td><?php if($journal->newTeacher !== null):?><?=$journal->newTeacher->fullName?><?php endif;?></td>
				<td></td>
				<td></td>
			</tr>
		<?php endforeach;?>
	</table>
</div>