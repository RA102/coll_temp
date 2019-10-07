<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\organization\Group */
/* @var $form yii\widgets\ActiveForm */
/* @var $specialities \common\models\handbook\Speciality[] */
?>

<div class="journal-form">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['options' => ['class => edit-journal-form']]); ?>
            <div class="row">
            	<div class="col-md-4">
            		<?= $form->field($model, 'date_ts')->textInput(['value' => $date_ts, 'disabled' => true]) ?>
            		<?= $form->field($model, 'group_id')->textInput(['value' => $group->caption_current, 'disabled' => true]) ?>
            		<?= $form->field($model, 'teacher_course_id')->textInput(['value' => $teacherCourse->disciplineName, 'disabled' => true]) ?>
            		<?= $form->field($model, 'teacher_id')->textInput(['value' => $teacherCourse->person->fullName, 'disabled' => true]) ?>
		            <?= $form->field($model, 'canceled')->checkbox([], false) ?>
            		<?= $form->field($model, 'reason')->textInput() ?>
					<?= $form->field($model, 'new_teacher_id')->widget(Select2::class, [
				        'data' => ArrayHelper::map($teachers, 'id', 'fullName'), /** @see \common\models\TeacherCourse::getFullname() */
				        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
				        'theme' => 'default',
				        'pluginOptions' => [
				            'allowClear' => true,
				        ],
				    ]) ?>    
					<?= $form->field($model, 'new_teacher_course_id')->widget(Select2::class, [
				        'data' => ArrayHelper::map($teacherCourses, 'id', 'disciplineName', 'personName'), /** @see \common\models\TeacherCourse::getFullname() */
				        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
				        'theme' => 'default',
				        'pluginOptions' => [
				            'allowClear' => true,
				        ],
				    ]) ?>
				    <?= $form->field($model, 'new_date_ts')->widget(DatePicker::class, [
				        'pluginOptions' => [
				            'autoclose' => true
				        ]
				    ]); ?>
				</div>
	        </div>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
