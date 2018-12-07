<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\search\InstitutionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="institution-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'country_id') ?>

    <?= $form->field($model, 'city_id') ?>

    <?= $form->field($model, 'parent_id') ?>

    <?php // echo $form->field($model, 'type_id') ?>

    <?php // echo $form->field($model, 'educational_form_id') ?>

    <?php // echo $form->field($model, 'organizational_legal_form_id') ?>

    <?php // echo $form->field($model, 'oid') ?>

    <?php // echo $form->field($model, 'server_id') ?>

    <?php // echo $form->field($model, 'street_id') ?>

    <?php // echo $form->field($model, 'house_number') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'fax') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'languages_iso') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'bin') ?>

    <?php // echo $form->field($model, 'foundation_year') ?>

    <?php // echo $form->field($model, 'website') ?>

    <?php // echo $form->field($model, 'max_grade') ?>

    <?php // echo $form->field($model, 'info') ?>

    <?php // echo $form->field($model, 'domain') ?>

    <?php // echo $form->field($model, 'db_name') ?>

    <?php // echo $form->field($model, 'db_user') ?>

    <?php // echo $form->field($model, 'db_password') ?>

    <?php // echo $form->field($model, 'initialization')->checkbox() ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'create_ts') ?>

    <?php // echo $form->field($model, 'update_ts') ?>

    <?php // echo $form->field($model, 'delete_ts') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
