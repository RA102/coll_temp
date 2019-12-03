<?php

use common\models\OptionalDisciplines;
use common\models\organization\Group;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDiscipline */

$this->title = $model->institutionDiscipline->caption_current;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планирование учебного процесса'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Дисциплины по выбору'), 'url' => ['optional']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="view-optional">
	<?php if (isset($model)):?>
		<div class="card-body skin-white">

	        <?= DetailView::widget([
	            'model' => $model,
	            'attributes' => [
	                [
	                    'attribute' => 'discipline_id',
	                    'value' => function (OptionalDisciplines $model) {
	                        return $model->institutionDiscipline->caption_current;
	                    },
	                ],
	                [
	                    'attribute' => 'teacher_id',
	                    'value' => function (OptionalDisciplines $model) {
	                        return $model->teacher->getFullname();
	                    },
	                ],
	                [
	                    'attribute' => 'groups',
	                    'value' => function (OptionalDisciplines $model) {
		                    return implode(', ', array_map(function (Group $group) {
		                        return $group->caption_current;
		                    }, $model->teacherCourse->groups));
	                    },
	                    'label' => 'Группы',
	                ],
	            ],
	        ]) ?>

	    </div>
	    <br>
	    <div class="card-body skin-white">

			<h2>Список студентов</h2>

	        <table class="table table-bordered">
	        	<tr>
	        		<th>ФИО</th>
	        		<th>Группа</th>
	        	</tr>
	        	<?php foreach ($students as $student) :?>
	        		<tr>
	        			<td><?=$student->getFullname()?></td>
	        			<td><?=$student->group->caption_current?></td>
	        		</tr>
	        	<?php endforeach;?>
	        </table>

		    <?php $form = ActiveForm::begin(['action' => ['add-students', 'id' => $model->id],'options' => ['method' => 'post']]); ?>

			    <?= $form->field($formmodel, 'group')->widget(Select2::class, [
			        'data' => ArrayHelper::map($groups, 'id', 'caption_current'), /** @see Employee::getFullName() */ // TODO rework to ajax
			        'options' => ['placeholder' => 'Выберите группу', 'class' => 'active-form-refresh-control'],
			        'theme' => 'default',
			        'pluginOptions' => [
			            'allowClear' => true,
			        ],
			    ])->label('Выберите группу, из которой нужно добавить студентов:') ?>

		    <div class="form-group">
		        <?= Html::submitButton(Yii::t('app', 'Добавить студентов'), ['class' => 'btn btn-success']) ?>
		    </div>

		    <?php ActiveForm::end(); ?>

	    </div>
	    <br>
    	<div class="row">
    		<div class="col-md-6">
			    <div class="card-body skin-white">
					<h2>Планирумое кол-во часов</h2>
					<p>
			            <?= Html::a(Yii::t('app', 'Update'), ['edit-optional', 'teacher_course_id' => $teacherCourse->id], ['class' => 'btn btn-primary']) ?>
			            <!-- <?= Html::a(Yii::t('app', 'Delete'), ['delete-optional', 'id' => $model->id], [
			                'class' => 'btn btn-danger',
			                'data' => [
			                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
			                    'method' => 'post',
			                ],
			            ]) ?> -->
			        </p>

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

			<!-- <div class="col-md-6">
				<div class="card-body skin-white">
					<h2>Календарно-тематический план</h2>
					<?= Html::a(Yii::t('app', 'Добавить'), ['optional-ktp-create', 'id' => $model->id], ['class' => 'btn btn-alert']) ?>
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
				    				<td><?//=$value['week']?></td>
				    				<td><?=$model->teacherCourse->getType($value['type'])?></td>
				    				<td><a href="ktp-create?id=<?=$model->id?>&lesson_number=<?=$value['lesson_number']?>"><i class="fa fa-edit"></i></td>
				    			</tr>
				    		<?php endforeach;?>
				    	<?php endif;?>
			    	</table>
				</div>
			</div>
				    </div> -->
		</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="card-body skin-white">
		    	<table class="table table-bordered">
		    		<tr>
		    			<th class="col-md-1">№ занятия</th>
		    			<th class="col-md-2">Дата</th>
		    			<th class="col-md-3">Тема урока</th>
		    			<!-- <th class="col-md-2">Недельный период</th> -->
		    			<th class="col-md-2">Способ обучения</th>
		    			<th class="col-md-1"></th>
		    		</tr>
		    		<?php foreach($dates as $key => $value) :?>
		    			<?php if ($model->ktp !== null && array_key_exists($key+1, $model->ktp)):?>
			    			<tr>
			    				<td><?=$key + 1 ?></td>
			    				<td><?=$value?></td>
			    				<td><?=$model->ktp[$key+1]['lesson_topic']?></td>
			    				<!-- <td><?//=$model->ktp[$key+1]['week']?></td> -->
			    				<td><?=$model->getType($model->ktp[$key+1]['type'])?></td>
			    				<td><a href="optional-ktp-create?id=<?=$model->id?>&lesson_number=<?=$model->ktp[$key+1]['lesson_number']?>"><i class="fa fa-edit"></i></a></td>
			    			</tr>
			    		<?php else:?>
			    			<tr>
			    				<td><?=$key + 1 ?></td>
			    				<td><?=$value?></td>
			    				<td></td>
			    				<!-- <td></td> -->
			    				<td></td>
			    				<td><a href="optional-ktp-create?id=<?=$model->id?>&lesson_number=<?=$key+1?>"><i class="fa fa-edit"></i></a></td>
			    			</tr>
			    		<?php endif;?>
		    		<?php endforeach;?>
			    	<?php if(count($dates) == 0):?>
			    		<tr>
			    			<td colspan="6">Расписание отсутствует</td>
			    		</tr>
			    	<?php endif;?>
		    	</table>
			</div>
		</div>
	</div>

	<?php else:?>
		<div class="card-body skin-white">
			<p>План отсутствует</p>
			<?= Html::a(Yii::t('app', 'Add'), ['edit-optional', 'teacher_course_id' => $teacherCourse->id], ['class' => 'btn btn-primary']) ?>
		</div>
	<?php endif;?>
</div>