<?php

use common\models\person\Employee;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Планируемый объем педагогической нагрузки на преподавателя';
?>

<div class="teacher-view">
	<h1><?=$this->title?></h1>
	<table class="table table-bordered">
		<tr>
			<th>Преподаватель</th>
			<td><?=$teacher->fullName?></td>
		</tr>
	</table>

	<div class="card-body skin-white" style="overflow-x: scroll;">
		<table class="table table-bordered table-striped">
			<tr>
				<th rowspan="2">Группа (при наличии)</th>
				<th rowspan="2">Дисциплина/Факультатив/Практика, ДП</th>
				<th colspan="8">I семестр</th>
				<th colspan="8">II семестр</th>
				<th rowspan="2">Итого за учебный год</th>
			</tr>
			<tr>
				<th>лекция</th>
				<th>семинар (ЛПЗ)</th>
				<th>курсовая  работа (проект)</th>
				<th>консультации</th>
				<th>контрольная работа</th>
				<th>зачет</th>
				<th>экзамен</th>
				<th>ВСЕГО ЗА 1 СЕМЕСТР</th>
				<th>лекция</th>
				<th>семинар (ЛПЗ)</th>
				<th>курсовая  работа (проект)</th>
				<th>консультации</th>
				<th>контрольная работа</th>
				<th>зачет</th>
				<th>экзамен</th>
				<th>ВСЕГО ЗА 2 СЕМЕСТР</th>
			</tr>
			<tr>
				<td class="btn-info" colspan="19">Обязательные дисциплины</td>
			</tr>
			<?php if($required == null):?>
				<tr>
					<td colspan="19">Не найдено</td>
				</tr>
			<?php endif;?>
			<?php foreach($required as $model):?>
				<tr>
					<td><?=$model->group->caption_current?></td>
					<td><?=$model->institutionDiscipline->caption_current?></td>
					<td><?=$model->lections_hours[1]?></td>
					<td><?=$model->seminars_hours[1]?></td>
					<td><?=$model->course_works_hours[1]?></td>
					<td><?=$model->consultations_hours[1]?></td>
					<td><?=$model->tests_hours[1]?></td>
					<td><?=$model->offsets_hours[1]?></td>
					<td><?=$model->exams_hours[1]?></td>
					<td><?=$model->totalHours(1)?></td>
					<td><?=$model->lections_hours[2]?></td>
					<td><?=$model->seminars_hours[2]?></td>
					<td><?=$model->course_works_hours[2]?></td>
					<td><?=$model->consultations_hours[2]?></td>
					<td><?=$model->tests_hours[2]?></td>
					<td><?=$model->offsets_hours[2]?></td>
					<td><?=$model->exams_hours[2]?></td>
					<td><?=$model->totalHours(2)?></td>
					<td><?=$model->totalHours(3)?></td>
				</tr>
			<?php endforeach;?>
			<tr>
				<td class="btn-info" colspan="19">Дисциплины по выбору</td>
			</tr>			
			<?php if($optional == null):?>
				<tr>
					<td colspan="19">Не найдено</td>
				</tr>
			<?php endif;?>
			<?php foreach($optional as $model):?>
				<tr>
					<td>-</td>
					<td><?=$model->institutionDiscipline->caption_current?></td>
					<td><?=$model->lections_hours[1]?></td>
					<td><?=$model->seminars_hours[1]?></td>
					<td><?=$model->course_works_hours[1]?></td>
					<td><?=$model->consultations_hours[1]?></td>
					<td><?=$model->tests_hours[1]?></td>
					<td><?=$model->offsets_hours[1]?></td>
					<td><?=$model->exams_hours[1]?></td>
					<td><?=$model->totalHours(1)?></td>
					<td><?=$model->lections_hours[2]?></td>
					<td><?=$model->seminars_hours[2]?></td>
					<td><?=$model->course_works_hours[2]?></td>
					<td><?=$model->consultations_hours[2]?></td>
					<td><?=$model->tests_hours[2]?></td>
					<td><?=$model->offsets_hours[2]?></td>
					<td><?=$model->exams_hours[2]?></td>
					<td><?=$model->totalHours(2)?></td>
					<td><?=$model->totalHours(3)?></td>
				</tr>
			<?php endforeach;?>
			<tr>
				<td class="btn-info" colspan="19">Факультативы</td>
			</tr>			
			<?php if($facultatives == null):?>
				<tr>
					<td colspan="19">Не найдено</td>
				</tr>
			<?php endif;?>
			<?php foreach($facultatives as $model):?>
				<tr>
					<td><?=$model->group->caption_current?></td>
					<td><?=$model->teacherCourse->disciplineName?></td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td><?=$model->hours[1]?></td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td><?=$model->hours[2]?></td>
					<td><?=$model->forYear()?></td>
				</tr>
			<?php endforeach;?>
			<tr>
				<td class="btn-info" colspan="19">Практика, ДП</td>
			</tr>			
			<?php if($practices == null):?>
				<tr>
					<td colspan="19">Не найдено</td>
				</tr>
			<?php endif;?>
			<?php foreach($practices as $model):?>
				<tr>
					<td><?=$model->group->caption_current?></td>
					<td><?=$model->practice->caption_current?></td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td><?=$model->hours[1]?></td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td><?=$model->hours[2]?></td>
					<td><?=$model->forYear()?></td>
				</tr>
			<?php endforeach;?>
			<tr>
				<td class="btn-success">ИТОГО</td>
				<td class="success"></td>
				<td class="success"><?=$teacher->totalPropertyHours($required, $optional, 1, 'lections_hours')?></td>
				<td class="success"><?=$teacher->totalPropertyHours($required, $optional, 1, 'seminars_hours')?></td>
				<td class="success"><?=$teacher->totalPropertyHours($required, $optional, 1, 'course_works_hours')?></td>
				<td class="success"><?=$teacher->totalPropertyHours($required, $optional, 1, 'consultations_hours')?></td>
				<td class="success"><?=$teacher->totalPropertyHours($required, $optional, 1, 'tests_hours')?></td>
				<td class="success"><?=$teacher->totalPropertyHours($required, $optional, 1, 'offsets_hours')?></td>
				<td class="success"><?=$teacher->totalPropertyHours($required, $optional, 1, 'exams_hours')?></td>
				<td class="success"><?=$teacher->totalSemester($required, $optional, $facultatives, $practices, 1)?></td>
				<td class="success"><?=$teacher->totalPropertyHours($required, $optional, 2, 'lections_hours')?></td>
				<td class="success"><?=$teacher->totalPropertyHours($required, $optional, 2, 'seminars_hours')?></td>
				<td class="success"><?=$teacher->totalPropertyHours($required, $optional, 2, 'course_works_hours')?></td>
				<td class="success"><?=$teacher->totalPropertyHours($required, $optional, 2, 'consultations_hours')?></td>
				<td class="success"><?=$teacher->totalPropertyHours($required, $optional, 2, 'tests_hours')?></td>
				<td class="success"><?=$teacher->totalPropertyHours($required, $optional, 2, 'offsets_hours')?></td>
				<td class="success"><?=$teacher->totalPropertyHours($required, $optional, 2, 'exams_hours')?></td>
				<td class="success"><?=$teacher->totalSemester($required, $optional, $facultatives, $practices, 2)?></td>
				<td class="success"><?=$teacher->totalYear($required, $optional, $facultatives, $practices)?></td>
			</tr>
		</table>
	</div>
</div>
