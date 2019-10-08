<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealApplication */
/* @var $form yii\widgets\ActiveForm */
/* @var $entrants \common\models\person\Entrant[] */
?>

<div class="card-body skin-white">
	<table class="table table-bordered">
		<tr>
			<th>Дисциплина:</th>
			<td><?=$teacherCourse->disciplineName?></td>
		</tr>
		<tr>
			<th>Группа</th>
			<td><?=$group->caption_current?></td>
		</tr>
		<tr>
			<th>Преподаватель</th>
			<td><?=$teacherCourse->person->fullName?></td>
		</tr>
	</table>	
</div>
<hr>

<div class="card-body skin-white">


    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

            <p>I семестр</p>

            <?= $form->field($model, 'lections_hours[1]')->textInput() ?>

            <?= $form->field($model, 'seminars_hours[1]')->textInput() ?>

            <?= $form->field($model, 'course_works_hours[1]')->textInput() ?>

            <?= $form->field($model, 'tests_hours[1]')->textInput() ?>

            <?= $form->field($model, 'offsets_hours[1]')->textInput() ?>

            <?= $form->field($model, 'consultations_hours[1]')->textInput() ?>

            <?= $form->field($model, 'exams_hours[1]')->textInput() ?>

        </div>

        <div class="col-md-4">

            <p>II семестр</p>

            <?= $form->field($model, 'lections_hours[2]')->textInput(['value' => 0]) ?>

            <?= $form->field($model, 'seminars_hours[2]')->textInput(['value' => 0]) ?>

            <?= $form->field($model, 'course_works_hours[2]')->textInput(['value' => 0]) ?>

            <?= $form->field($model, 'tests_hours[2]')->textInput(['value' => 0]) ?>

            <?= $form->field($model, 'offsets_hours[2]')->textInput(['value' => 0]) ?>

            <?= $form->field($model, 'consultations_hours[2]')->textInput(['value' => 0]) ?>

            <?= $form->field($model, 'exams_hours[2]')->textInput(['value' => 0]) ?>
            
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
