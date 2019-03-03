<?php

use common\models\Country;
use common\models\CountryUnit;
use common\models\Street;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\components\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $form \common\forms\InstitutionForm */
/* @var $activeForm yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Organization');
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="institution-form skin-white">
    <div class="card-body">
    <?php
    Pjax::begin([
        'id' => 'list-pjax',
        'formSelector' => '#js-update',
        'scrollTo' => 'false',
    ]);
    ?>

    <?php $activeForm = ActiveForm::begin([
        'id' => 'js-update',
        'enableClientValidation' => false,
        'options' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $activeForm->field($form, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $activeForm->field($form, 'max_shift')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $activeForm->field($form, 'enable_fraction')->checkbox() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $activeForm->field($form, 'description')->textarea(['rows' => 3 ]) ?>
        </div>

    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $activeForm->field($form, 'min_grade')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $activeForm->field($form, 'max_grade')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $activeForm->field($form, 'foundation_year')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $activeForm->field($form, 'bin')->textInput() ?>
        </div>
    </div>

    <div class="row">
            <?= Html::tag('div', $activeForm->field($form, 'country_id')->dropDownList(
                ArrayHelper::map(Country::find()->all(), 'id', 'caption_current'), [
                'class' => 'form-control active-form-refresh-control',
                'prompt' => ''
            ]), ['class' => 'col-md-3']) ?>

            <?php
            if ($form->country_id) {
                $parent_id = null;
                $children = [];
                $count = 0;
                while (true) {
                    $children = CountryUnit::find()->andWhere([
                        'country_id' => $form->country_id,
                        'parent_id' => $parent_id,
                    ])->all();
                    if ($children) {
                        $form->hasCountryUnit = true;
                        echo Html::tag('div', $activeForm->field($form, "city_ids[{$count}]")->dropDownList(
                            ArrayHelper::map($children, 'id', 'caption_current'), [
                            'class' => 'form-control active-form-refresh-control',
                            'prompt' => ''
                        ])->label(Yii::t('app', 'Country unit'), ['class' => 'shy']), ['class' => 'col-md-2']);

                        if (isset($form->city_ids[$count]) && $form->city_ids[$count]) {
                            $parent_id = $form->city_ids[$count];
                            $count++;

                            continue;
                        }
                    }

                    break;
                }

                if ($parent_id && !$children) {
                    $form->hasStreet = true;
                    echo Html::tag('div', $activeForm->field($form, "street_id")->dropDownList(
                        ArrayHelper::map(Street::find()->andWhere(['city_id' => $parent_id])->all(), 'id', 'caption'), [
                        'class' => 'form-control',
                        'prompt' => ''
                    ]), ['class' => 'col-md-3']);
                }
                if ($parent_id && !$children && $form->hasStreet) {
                    $form->hasHouseNumber = true;
                    echo Html::tag('div', $activeForm->field($form, 'house_number'), ['class' => 'col-md-2']);
                }
            }

            if (!$form->hasCountryUnit) {
                echo $activeForm->field($form, 'city_ids[]')->hiddenInput(['value' => null])->label(false);
            }
            if (!$form->hasStreet) {
                echo $activeForm->field($form, "street_id")->hiddenInput(['value' => null])->label(false);
            }
            if (!$form->hasHouseNumber) {
                echo $activeForm->field($form, "house_number")->hiddenInput(['value' => null])->label(false);
            }

            ?>
        <div class="col-md-3">
        </div>
        <div class="col-md-3">
        </div>
        <div class="col-md-3">
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $activeForm->field($form, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $activeForm->field($form, 'fax')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $activeForm->field($form, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $activeForm->field($form, 'website')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
    </div>
</div>
