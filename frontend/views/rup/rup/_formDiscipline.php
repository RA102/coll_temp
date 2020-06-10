<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDiscipline */
/* @var $form yii\widgets\ActiveForm */

/** @see Discipline::caption_current $disciplines */
$disciplines = ArrayHelper::map(\common\models\Discipline::find()->all(), 'id', 'caption_current');
?>
<?php Pjax::begin() ?>
    <div class="institution-discipline-form">

        <?php $form = ActiveForm::begin([
            'id' => 'form-create',
            'action' => '/institution-discipline/create',
            'options' => ['name' => 'subjects'],
        ]); ?>

        <?= $form->field($model, 'caption_ru')->textInput() ?>

        <?= $form->field($model, 'caption_kk')->textInput() ?>

        <?= $form->field($model, 'types')->widget(Select2::class, [
            'data' => \common\helpers\InstitutionDisciplineHelper::getTypeList(),
            'options' => [
                'placeholder' => '...',
                'class' => 'active-form-refresh-control',
                'multiple' => true,
            ],
            'theme' => 'default',
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>

        <?= $form->field($model, 'teachers')->widget(Select2::class, [
            'data' => ArrayHelper::map($teachers, 'id', 'fullname'), // TODO rework to ajax
            'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
            'theme' => 'default',
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => true,
            ],
        ])->label('Преподаватели') ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'id' => 'create-ajax']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
<?php Pjax::end() ?>