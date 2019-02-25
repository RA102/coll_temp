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
        <div class="loader js-loader">
            <div class="lds-ripple"><div></div><div></div></div>
        </div>
    </div>
</div>

<style>
    .loader {
        z-index: 10;
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        display: none;
        align-items: center;
        justify-content: center;
        background-color: rgba(255, 255, 255, 0.5);
    }

    .loader--loading {
        display: flex;
    }

    .lds-ripple {
        display: inline-block;
        position: relative;
        width: 64px;
        height: 64px;
    }
    .lds-ripple div {
        position: absolute;
        border: 4px solid #000;
        opacity: 1;
        border-radius: 50%;
        animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
    }
    .lds-ripple div:nth-child(2) {
        animation-delay: -0.5s;
    }
    @keyframes lds-ripple {
        0% {
            top: 28px;
            left: 28px;
            width: 0;
            height: 0;
            opacity: 1;
        }
        100% {
            top: -1px;
            left: -1px;
            width: 58px;
            height: 58px;
            opacity: 0;
        }
    }
</style>