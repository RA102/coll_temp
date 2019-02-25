<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $model frontend\models\forms\LessonForm */
/* @var $teacherCourses common\models\TeacherCourse[] */
?>

<div class="modal fade" id="modal-lesson-create" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md modal-tiny" role="document">
        <div class="modal-content modal-common">
            <div class="modal-header">
                <h4 class="modal-title text-center"><?= Yii::t('app', 'New Lesson') ?></h4>
            </div>
            <div class="modal-body">

                <?php $form = ActiveForm::begin([
                    'id' => 'modal-form'
                ]); ?>

                <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

                <?= $form->field($model, 'teacher_course_id')->widget(Select2::class, [
                    'data' => ArrayHelper::map($teacherCourses, 'id', 'fullname'),
                    'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]) ?>

                <?= $form->field($model, 'start')->textInput([
                    'readonly' => true,
                ]) ?>

                <?= $form->field($model, 'end')->textInput([
                    'readonly' => true,
                ]) ?>

                <?php ActiveForm::end(); ?>

                <button class="btn btn-success js-modal-save" type="button">Save</button>
                <button class="btn btn-default js-modal-cancel" data-dismiss="modal" type="button">Cancel</button>
                <button class="btn btn-danger js-modal-delete" type="button">Delete</button>
            </div>
        </div>
    </div>
</div>