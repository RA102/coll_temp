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

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планирование учебного процесса'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>График экзаменов</h1>
<!-- <?= Html::a(Yii::t('app', 'Add'), ['add-exam'], ['class' => 'btn btn-alert']) ?> -->

<div class="exams">
	<div class="card-body skin-white">
		<h2>График экзаменов</h2>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered">
					<tr>
						<th>Группы</th>
						<th>Дисциплина</th>
						<th>Номер урока</th>
						<th>Дата</th>
					</tr>
					<?php foreach ($exams as $exam):?>
						<tr>
							<?php if (is_array($exam['group_id'])) :?>
								<td>
									<?php foreach ($exam['group_id'] as $group_id) :?>
										<?=Group::findOne($group_id)->caption_current?> <br>
									<?php endforeach;?>
								</td>
							<?php else :?>
								<td><?=Group::findOne($exam['group_id'])->caption_current?></td>
							<?php endif;?>
							<td><?=InstitutionDiscipline::findOne($exam['discipline_id'])->caption_current?></td>
							<td><?=$exam['lesson_number']?></td>
							<td><?=$dates[$exam['lesson_number']-1]?></td>
						</tr>
					<?php endforeach;?>
				</table>
			</div>
		</div>
	</div>
	<br>
	<div class="card-body skin-white">
	<h2>График обязательных контрольных работ</h2>
		<table class="table table-bordered table-striped">
			<tr>
				<th>Группы</th>
				<th>Предмет</th>
				<th>Номер урока</th>
				<th>Дата</th>
			</tr>
			<?php foreach ($tests as $test):?>
				<tr>
					<?php if (is_array($test['group_id'])) :?>
						<td>
							<?php foreach ($test['group_id'] as $group_id) :?>
								<?=Group::findOne($group_id)->caption_current?> <br>
							<?php endforeach;?>
						</td>
					<?php else :?>
						<td><?=Group::findOne($test['group_id'])->caption_current?></td>
					<?php endif;?>
					<td><?=InstitutionDiscipline::findOne($test['discipline_id'])->caption_current?></td>
					<td><?=$test['lesson_number']?></td>
					<td><?=$dates[$test['lesson_number']-1]?></td>
				</tr>
			<?php endforeach;?>
		</table>
	</div>
	<br>
	<div class="card-body skin-white">
	<h2>График курсовых работ</h2>
		<table class="table table-bordered table-striped">
			<tr>
				<th>Группы</th>
				<th>Предмет</th>
				<th>Номер урока</th>
				<th>Дата</th>
			</tr>
			<?php foreach ($course_works as $course_work):?>
				<tr>
					<?php if (is_array($course_work['group_id'])) :?>
						<td>
							<?php foreach ($course_work['group_id'] as $group_id) :?>
								<?=Group::findOne($group_id)->caption_current?> <br>
							<?php endforeach;?>
						</td>
					<?php else :?>
						<td><?=Group::findOne($course_work['group_id'])->caption_current?></td>
					<?php endif;?>
					<td><?=InstitutionDiscipline::findOne($course_work['discipline_id'])->caption_current?></td>
					<td><?=$course_work['lesson_number']?></td>
					<td><?=$dates[$course_work['lesson_number']-1]?></td>
				</tr>
			<?php endforeach;?>
		</table>
	</div>
</div>
