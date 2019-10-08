<?php

use common\models\RequiredDisciplines;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDiscipline */

$this->title = 'Дисциплина';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="view-required">
    <?php if ($model !== null):?>
	<div class="card-head">
	        <?= DetailView::widget([
	            'model' => $model,
	            'attributes' => [
	                [
	                    'attribute' => 'group_id',
	                    'value' => $group->caption_current,
	                ],
	                [
	                    'attribute' => 'discipline_id',
	                    'value' => function (RequiredDisciplines $model) {
                        	return $model->teacherCourse->disciplineName;
	                    },
	                    'label' => 'Дисциплина'
	                ],
	                [
	                    'attribute' => 'teacher_id',
	                    'value' => function (RequiredDisciplines $model) {
	                        return $model->teacherCourse->person->fullName;
	                    },
	                    'label' => 'Преподаватель'
	                ],
	            ],
	        ]) ?>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="card-body skin-white">
				<h2>Планирумое кол-во часов</h2>
	            <?= Html::a(Yii::t('app', 'Update'), ['edit-required', 'teacher_course_id' => $teacherCourse->id, 'group_id' => $group->id], ['class' => 'btn btn-primary']) ?>
				<table class="table table-bordered">
					<tr>
						<th></th>
						<th>Семестр I</th>
						<th>Семестр II</th>
						<th>За год</th>
					</tr>
					<tr>
						<th>Лекции (ч)</th>
						<td><?=$model->lections_hours[1]?></td>
						<td><?=$model->lections_hours[2]?></td>
						<td><?=$model->forYear('lections_hours')?></td>
					</tr>
					<tr>
						<th>Семинары (ч)</th>
						<td><?=$model->seminars_hours[1]?></td>
						<td><?=$model->seminars_hours[2]?></td>
						<td><?=$model->forYear('seminars_hours')?></td>
					</tr>
					<tr>
						<th>Курсовые (ч)</th>
						<td><?=$model->course_works_hours[1]?></td>
						<td><?=$model->course_works_hours[2]?></td>
						<td><?=$model->forYear('course_works_hours')?></td>
					</tr>
					<tr>
						<th>Контрольные (ч)</th>
						<td><?=$model->tests_hours[1]?></td>
						<td><?=$model->tests_hours[2]?></td>
						<td><?=$model->forYear('tests_hours')?></td>
					</tr>
					<tr>
						<th>Зачёт (ч)</th>
						<td><?=$model->offsets_hours[1]?></td>
						<td><?=$model->offsets_hours[2]?></td>
						<td><?=$model->forYear('offsets_hours')?></td>
					</tr>
					<tr>
						<th>Консультации (ч)</th>
						<td><?=$model->consultations_hours[1]?></td>
						<td><?=$model->consultations_hours[2]?></td>
						<td><?=$model->forYear('consultations_hours')?></td>
					</tr>
					<tr>
						<th>Экзамены (ч)</th>
						<td><?=$model->exams_hours[1]?></td>
						<td><?=$model->exams_hours[2]?></td>
						<td><?=$model->forYear('exams_hours')?></td>
					</tr>
					<tr class="success">
						<th>Всего за год</th>
						<td><?=$model->totalHours(1)?></td>
						<td><?=$model->totalHours(2)?></td>
						<td><?=$model->totalHours(3)?></td>
					</tr>
				</table>

		    </div>
		</div>
		<div class="col-md-6">
		    <div class="card-body skin-white">
		    	<h2>Календарно-тематический план</h2>
		        <?= Html::a(Yii::t('app', 'Добавить'), ['required-ktp-create', 'id' => $model->id], ['class' => 'btn btn-alert']) ?>
		    	<table class="table table-bordered">
		    		<tr>
		    			<th>№ занятия</th>
		    			<th>Тема урока</th>
		    			<th>Недельный период</th>
		    			<th>Способ обучения</th>
		    		</tr>
		    		<?php if($model->ktp !== null):?>
			    		<?php foreach($model->ktp as $key => $value) :?>
			    			<tr>
			    				<td><?=$value['lesson_number']?></td>
			    				<td><?=$value['lesson_topic']?></td>
			    				<td><?=$value['week']?></td>
			    				<td><?=$model->getType($value['type'])?></td>
			    				<td><a href="ktp-create?id=<?=$model->id?>&lesson_number=<?=$value['lesson_number']?>"><i class="fa fa-edit"></i></td>
			    			</tr>
			    		<?php endforeach;?>
			    	<?php endif;?>
		    	</table>
		    </div>
		</div>
	</div>
	<?php else:?>
		<div class="card-body skin-white">
			<p>План отсутствует</p>
	        <?= Html::a(Yii::t('app', 'Добавить'), ['edit-required', 'teacher_course_id' => $teacherCourse->id, 'group_id' => $group->id], ['class' => 'btn btn-alert']) ?>
		</div>
    <?php endif;?>
</div>