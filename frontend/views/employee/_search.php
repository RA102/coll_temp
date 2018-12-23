<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\search\EmployeeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'nickname') ?>

    <?= $form->field($model, 'firstname') ?>

    <?= $form->field($model, 'lastname') ?>

    <?php // echo $form->field($model, 'middlename') ?>

    <?php // echo $form->field($model, 'birth_date') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'nationality_id') ?>

    <?php // echo $form->field($model, 'iin') ?>

    <?php // echo $form->field($model, 'is_pluralist') ?>

    <?php // echo $form->field($model, 'birth_country_id') ?>

    <?php // echo $form->field($model, 'birth_city_id') ?>

    <?php // echo $form->field($model, 'birth_place') ?>

    <?php // echo $form->field($model, 'language') ?>

    <?php // echo $form->field($model, 'oid') ?>

    <?php // echo $form->field($model, 'alledu_id') ?>

    <?php // echo $form->field($model, 'alledu_server_id') ?>

    <?php // echo $form->field($model, 'pupil_id') ?>

    <?php // echo $form->field($model, 'owner_id') ?>

    <?php // echo $form->field($model, 'server_id') ?>

    <?php // echo $form->field($model, 'is_subscribed')->checkbox() ?>

    <?php // echo $form->field($model, 'portal_uid') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'create_ts') ?>

    <?php // echo $form->field($model, 'delete_ts') ?>

    <?php // echo $form->field($model, 'import_ts') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
