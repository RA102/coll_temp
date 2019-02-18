<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $allocationModel \frontend\models\forms\GroupAllocationForm */
/* @var $years [] */

$this->title = Yii::t('app', 'Groups allocation');
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="group-index skin-white">

    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'id' => 'group-allocation-form',
            'enableClientValidation' => false,
            'options' => [
                'validateOnSubmit' => true,
            ],
        ]); ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($allocationModel, "class")->dropDownList(
                    $years, [
                    'class' => 'form-control active-form-refresh-control',
                    'prompt' => ''
                ]);?>
            </div>
            <div class="col-md-6">
                <?= $form->field($allocationModel, "group_id")->dropDownList(
                    [], [
                    'class' => 'form-control active-form-refresh-control',
                    'prompt' => ''
                ]);?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
