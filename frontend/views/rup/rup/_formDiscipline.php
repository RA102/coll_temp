<?php

use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDiscipline */
/* @var $form yii\widgets\ActiveForm */

/** @see Discipline::caption_current $disciplines */
$disciplines = ArrayHelper::map(\common\models\Discipline::find()->all(), 'id', 'caption_current');?>
<?php Pjax::begin() ?>
    <div class="institution-discipline-form">
        <?php $form = ActiveForm::begin([
            'id' => 'form-create-subjects',
            'options' => ['name' => 'subjects'],
        ]); ?>


        <?= $form->field($model, 'caption_ru')->textInput(); ?>

        <?= $form->field($model, 'caption_kk')->textInput(); ?>

        <div class="form-group">
            <?= Html::a('Добавить', '/institution-discipline/create', ['class' => 'btn btn-success', 'id' => 'create-ajax', 'type' => 'submit']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<?php Pjax::end() ?>