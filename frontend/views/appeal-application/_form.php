<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealApplication */
/* @var $form yii\widgets\ActiveForm */
/* @var $entrants \common\models\person\Entrant[] */
?>

<div class="appeal-application-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'entrant_id')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map($entrants, 'id', function(\common\models\person\Entrant $model) {
            return $model['lastname'].' '.$model['firstname'].' '.$model['middlename'];
        }),
        'options' => ['placeholder' => ''],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'reason')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
