<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealApplication */
/* @var $form yii\widgets\ActiveForm */
/* @var $entrants \common\models\person\Entrant[] */

$this->title = 'Календарно-тематический план';

if (get_class($model) == 'common\models\RequiredDisciplines') {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планирование учебного процесса'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Обязательные дисциплины'), 'url' => ['/plan/required']];
    $this->params['breadcrumbs'][] = ['label' => $model->teacherCourse->disciplineName, 'url' => ['/plan/view-required-groups', 'teacher_course_id' => $model->teacher_course_id]];
    $this->params['breadcrumbs'][] = ['label' => $model->group->caption_current, 'url' => ['/plan/view-required', 'teacher_course_id' => $model->teacherCourse->id, 'group_id' => $model->group->id]];
    $this->params['breadcrumbs'][] = $this->title;
} 
elseif (get_class($model) == 'common\models\OptionalDisciplines') {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планирование учебного процесса'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Дисциплины по выбору'), 'url' => ['/plan/optional']];
    $this->params['breadcrumbs'][] = ['label' => $model->teacherCourse->disciplineName, 'url' => ['/plan/view-optional', 'teacher_course_id' => $model->teacherCourse->id]];
    $this->params['breadcrumbs'][] = $this->title;    
}
?>

<div class="appeal-application-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

            <?= $form->field($formmodel, 'lesson_number')->textInput()->label('Номер урока') ?>

            <?= $form->field($formmodel, 'lesson_topic')->textInput()->label('Тема урока') ?>

            <!-- <?= $form->field($formmodel, 'week')->textInput()->label('Неделя') ?> -->

            <?= $form->field($formmodel, 'type')->widget(Select2::class, [
                'data' => $model->teacherCourse->types, 
                'options' => ['placeholder' => 'Выберите способ', 'class' => 'active-form-refresh-control'],
                'theme' => 'default',
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Способ') ?>


        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
