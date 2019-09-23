<?php

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

    <?php $form = ActiveForm::begin(); ?>
    <?php foreach ($group->students as $student):?>
        <?= $form->field($model, 'data['.$student->id.']')->radioList([
            '1' => 'н/б',
            '2' => 'н/у',
            '3' => 'присутствует',
        ], ['value' => array_key_exists($student->id, $model->data) ? $model->data[$student->id] : '3'])->label($student->getFullname()) ?> 
    <?php endforeach;?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
