<?php

use common\models\person\Person;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TeacherCourse */
/* @var $form yii\widgets\ActiveForm */

$institution = \Yii::$app->user->identity->institution; // TODO move to controller/service
$persons = Person::find()->joinWith([
    /** @see Person::getPersonInstitutionLinks() */
    'personInstitutionLinks' => function (\yii\db\ActiveQuery $query) use ($institution) {
        $query->andWhere([
            'link.person_institution_link.institution_id' => $institution->id,
        ]);
    },
])->all();
$persons = ArrayHelper::map($persons, 'id', 'fullName');
?>

<div class="teacher-course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'teacher_id')->widget(Select2::class, [
        'data' => $persons, // TODO rework to ajax
        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_ts')->widget(DatePicker::class, [
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]); ?>

    <?= $form->field($model, 'end_ts')->widget(DatePicker::class, [
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
