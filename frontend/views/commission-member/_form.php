<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\reception\Commission */
/* @var $form yii\widgets\ActiveForm */
/* @var $employees \common\models\person\Employee[] */
/* @var $roles[] */
?>

<div class="commission-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'member_id')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map($employees, 'id', function(\common\models\person\Employee $model) {
            return $model['lastname'].' '.$model['firstname'].' '.$model['middlename'].' '.$model['iin'];
        }),
        'options' => ['placeholder' => ''],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'role')->dropDownList($roles) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
