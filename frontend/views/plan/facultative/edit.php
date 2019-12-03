<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealApplication */
/* @var $form yii\widgets\ActiveForm */
/* @var $entrants \common\models\person\Entrant[] */

$this->title = 'Планирование';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планирование учебного процесса'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Факультативные занятия'), 'url' => ['/plan/facultative']];
$this->params['breadcrumbs'][] = ['label' => $teacherCourse->disciplineName, 'url' => ['/plan/view-facultative', 'teacher_course_id' => $teacherCourse->id, 'group_id' => $group->id]];
$this->params['breadcrumbs'][] = $this->title;
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
<br>

<div class="card-body skin-white">


    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

            <p>I семестр</p>

            <?= $form->field($model, 'hours[1]')->textInput() ?>

        </div>

        <div class="col-md-4">

            <p>II семестр</p>

            <?= $form->field($model, 'hours[2]')->textInput() ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
