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
    <div class="card-body">
        <?php $form = ActiveForm::begin(['options' => ['class => edit-journal-form']]); ?>
            <div class="row">
                <?php foreach ($group->students as $student):?>
                    <div class="col-md-6">
                        <?= $form->field($model, 'data['.$student->id.'][attendance]')->radioList([
                            '1' => 'н/б',
                            '2' => 'н/у',
                            '3' => 'присутствует',
                        ], ['value' => array_key_exists($student->id, $model->data) ? $model->data[$student->id] : '3'])->label($student->getFullname()) ?> 
                        <?= $form->field($model, 'data['.$student->id.'][mark]')->textInput() ?>
                    </div>
                <?php endforeach;?>
            </div>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
