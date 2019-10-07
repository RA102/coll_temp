<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\forms\TeacherCourseForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $teachers common\models\person\Employee[] */
/* @var $groups common\models\organization\Group[] */

?>

<div class="add-lesson-form">

	<div class="card-body skin-white">

	    <?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'group_id')->textInput(['value' => $group->caption_current, 'disabled' => true]) ?>

	    <?= $form->field($model, 'weekday')->textInput(['value' => $model->getWeekday($model->weekday), 'disabled' => true]) ?>

	    <?= $form->field($model, 'lesson_number')->textInput(['disabled' => true]) ?>

	    <?= $form->field($model, 'teacher_course_id')->widget(Select2::class, [
	        'data' => ArrayHelper::map($teacherCourses, 'id', 'disciplineName'), /** @see Employee::getFullName() */ // TODO rework to ajax
	        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
	        'theme' => 'default',
	        'pluginOptions' => [
	            'allowClear' => true,
	        ],
	    ]) ?>

	    <?= $form->field($model, 'classroom_id')->widget(Select2::class, [
	        'data' => ArrayHelper::map($classrooms, 'id', 'number'), /** @see Employee::getFullName() */ // TODO rework to ajax
	        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
	        'theme' => 'default',
	        'pluginOptions' => [
	            'allowClear' => true,
	        ],
	    ]) ?>

        <?= $form->field($model, 'double')->checkbox() ?>


	    <div class="form-group">
	        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>
