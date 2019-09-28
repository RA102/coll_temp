<?php

use common\models\organization\Group;
use common\models\organization\InstitutionDiscipline;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'График экзаменов';

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealApplication */
/* @var $form yii\widgets\ActiveForm */
/* @var $entrants \common\models\person\Entrant[] */
?>

<h1>График экзаменов</h1>
<?= Html::a(Yii::t('app', 'Add'), ['add-exam'], ['class' => 'btn btn-alert']) ?>

<div class="exams">
	<div class="card-body skin-white">
			<h2>График экзаменов</h2>
s		<div class="row">
			<div class="col-md-8">
				<table class="table table-bordered">
					<tr>
						<th>Группа</th>
						<th>Дисциплина</th>
						<th>Способ</th>
						<th>Неделя</th>
					</tr>
					<?php foreach($exams as $exam):?>
						<tr>
							<td><?=$exam->group->caption_current?></td>
							<td><?=$exam->institutionDiscipline->caption_current?></td>
							<td><?=$exam->examType($exam->exam_type)?></td>
							<td><?=$exam->week?></td>
						</tr>
					<?php endforeach;?>
				</table>
			</div>
		</div>
	</div>
	<hr>
	<div class="card-body skin-white">
	<h2>График обязательных контрольных работ</h2>
		<table class="table table-bordered">
			<tr>
				<th>Группа</th>
				<th>Предмет</th>
				<th>Номер недели</th>
			</tr>
			<?php foreach ($tests as $test):?>
				<tr>
					<td><?=Group::findOne($test['group_id'])->caption_current?></td>
					<td><?=InstitutionDiscipline::findOne($test['discipline_id'])->caption_current?></td>
					<td><?=$test['week']?></td>
				</tr>
			<?php endforeach;?>
		</table>
	</div>
	<hr>
	<div class="card-body skin-white">
	<h2>График курсовых работ</h2>
		<table class="table table-bordered">
			<tr>
				<th>Группа</th>
				<th>Предмет</th>
				<th>Номер недели</th>
			</tr>
			<?php foreach ($course_works as $course_work):?>
				<tr>
					<td><?=Group::findOne($course_work['group_id'])->caption_current?></td>
					<td><?=InstitutionDiscipline::findOne($course_work['discipline_id'])->caption_current?></td>
					<td><?=$course_work['week']?></td>
				</tr>
			<?php endforeach;?>
		</table>
	</div>
</div>
