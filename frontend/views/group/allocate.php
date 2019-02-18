<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

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
                        'prompt' => '',
                        'id' => 'class-id'
                ]);?>
            </div>
            <div class="col-md-6">
                <?= $form->field($allocationModel, 'group_id')->widget(DepDrop::classname(), [
                    'options' => ['id' => 'group-id'],
                    'pluginOptions' => [
                        'depends' => ['class-id'],
                        'placeholder' => Yii::t('app', 'Select group'),
                        'url'=>Url::to(['/group/by-year']),
                        'loadingText' => '',
                    ]
                ]);?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
