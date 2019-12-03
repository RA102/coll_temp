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

<div class="teacher-course-form">

    <p><b>Начало курса: </b><?=$teacherCourse->start_ts?></p>
    <p><b>Конец курса: </b><?=$teacherCourse->end_ts?></p>
    <p><b>Длительность курса (недель): </b><?=count($weeks)?></p>
    <p><b>День недели: </b><?=$current_day?></p>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date_ts')->textInput([
        'readonly' => true,
    ]) ?>

    <?php 
    foreach ($all_days as $day) {
        if ($day !== date('Y-m-d', strtotime($model->date_ts))) {
            echo $form->field($model, 'dates')->checkbox(
                [
                    'name' => "Date[$all_days[$day]]",
                    'value' => $day,
                ], false)->label(date('d-m-Y', strtotime($day)));
        }
    }
    ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
