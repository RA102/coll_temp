<?php

use common\models\OptionalDisciplines;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDiscipline */

$this->title = 'Дисциплина';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="view-optional">
	<div class="card-body skin-white">

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update-optional', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete-optional', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>

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
            ],
        ]) ?>

    </div>
    <hr>
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
    <hr>
    <div class="card-body skin-white">

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