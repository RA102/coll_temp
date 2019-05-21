<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use common\models\Country;
use common\models\CountryUnit;
use common\models\organization\EducationalForm;
use \common\models\organization\OrganizationalLegalForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use common\components\ActiveForm;
use kartik\date\DatePicker;
use common\helpers\PersonHelper;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="app flex-row align-items-center">
    <div class="container">
        <div class="site-signup mt-4">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card mx-4 mt-4">
                        <?php $form = ActiveForm::begin([
                            'id' => 'js-update',
                            'enableClientValidation' => false,
                            'options' => [
                                'validateOnSubmit' => true,
                            ],
                        ]); ?>
                        <div class="card-body p-4">
                            <h1>Регистрация</h1>
                            <p class="text-muted">Оформить заявку на регистрацию в системе «Бiлiмал».</p>

                            <fieldset>
                                <legend>Организация</legend>
                                <?= $form->field($model, 'educational_form_id')
                                    ->dropDownList(ArrayHelper::map(
                                        EducationalForm::find()->all(),
                                        'id',
                                        'caption_current')
                                    )
                                ?>

                                <?php
                                    $type_parent_id = 0;
                                    $type_children = [];
                                    $type_count = 0;
                                    while (true) {
                                        $type_children = \common\models\organization\InstitutionType::find()->andWhere([
                                            'parent_id' => $type_parent_id,
                                        ])->all();
                                        if ($type_children) {
                                            $label = $type_parent_id === 0
                                                ? Yii::t('app', 'Organization type')
                                                : false;
                                            $model->hasInstitutionType = true;
                                            echo $form->field($model, "type_ids[{$type_count}]")->dropDownList(
                                                ArrayHelper::map($type_children, 'id', 'caption_current'), [
                                                'class' => 'form-control active-form-refresh-control',
                                                'prompt' => ''
                                            ])->label($label);

                                            if (isset($model->type_ids[$type_count]) && $model->type_ids[$type_count]) {
                                                $type_parent_id = $model->type_ids[$type_count];
                                                $type_count++;

                                                continue;
                                            }
                                        }

                                        break;
                                    }


                                if (!$model->hasInstitutionType) {
                                    echo $form->field($model, 'type_ids[]')->hiddenInput(['value' => null])->label(false);
                                }

                                ?>

                                <?= $form->field($model, 'organizational_legal_form_id')
                                    ->dropDownList(ArrayHelper::map(
                                        OrganizationalLegalForm::find()->all(),
                                        'id',
                                        'caption_current')
                                    )
                                ?>

                                <?= $form->field($model, 'name') ?>

                                <?= $form->field($model, 'country_id')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(Country::find()->all(), 'id', 'caption_current'),
                                    'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
                                    'theme' => 'default',
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ]);?>

                                <?php
                                if ($model->country_id) {
                                    $parent_id = null;
                                    $children = [];
                                    $count = 0;
                                    while (true) {
                                        $children = CountryUnit::find()->andWhere([
                                            'country_id' => $model->country_id,
                                            'parent_id' => $parent_id,
                                        ])->all();
                                        if ($children) {
                                            $model->hasCountryUnit = true;

                                            echo $form->field($model, "city_ids[{$count}]")->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map($children, 'id', 'caption_current'),
                                                'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
                                                'theme' => 'default',
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                            ])->label(false);

                                            if (isset($model->city_ids[$count]) && $model->city_ids[$count]) {
                                                $parent_id = $model->city_ids[$count];
                                                $count++;

                                                continue;
                                            }
                                        }

                                        break;
                                    }

                                    if ($parent_id && !$children) {
                                        $model->hasStreet = true;

                                        echo $form->field($model, "street_id")->widget(Select2::classname(), [
                                            'data' => ArrayHelper::map(\common\models\Street::find()->andWhere(['city_id' => $parent_id])->all(), 'id', 'caption_current'),
                                            'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
                                            'theme' => 'default',
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                            ],
                                        ])->label(false);
                                    }
                                    if ($parent_id && !$children && $model->hasStreet) {
                                        $model->hasHouseNumber = true;
                                        echo $form->field($model, 'house_number');
                                    }
                                }

                                if (!$model->hasCountryUnit) {
                                    echo $form->field($model, 'city_ids[]')->hiddenInput(['value' => null])->label(false);
                                }
                                if (!$model->hasStreet) {
                                    echo $form->field($model, "street_id")->hiddenInput(['value' => null])->label(false);
                                }
                                if (!$model->hasHouseNumber) {
                                    echo $form->field($model, "house_number")->hiddenInput(['value' => null])->label(false);
                                }

                                ?>
                            </fieldset>

                            <fieldset>
                                <legend>Администратор/Директор</legend>
                                <?= $form->field($model, 'lastname') ?>
                                <?= $form->field($model, 'firstname') ?>
                                <?= $form->field($model, 'middlename') ?>
                                <?= $form->field($model, 'iin')
                                    ->textInput(['maxlength' => true])
                                    ->widget(\yii\widgets\MaskedInput::class, ['mask' => '999999999999'])
                                ?>
                                <?= $form->field($model, 'birth_date')->widget(DatePicker::class, [
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ]); ?>
                                <?= $form->field($model, 'sex')->dropDownList(PersonHelper::getSexList()) ?>
                                <?= $form->field($model, 'email') ?>
                                <?= $form->field($model, 'phone')
                                    ->textInput()
                                    ->widget(\yii\widgets\MaskedInput::class, ['mask' => '+7 (999) 999-99-99',]) ?>
                            </fieldset>

                        </div>
                        <div class="card-footer p-4">
                            <?= Html::submitButton(
                                Yii::t('app', 'Create'),
                                ['class' => 'btn btn-success btn-block','name' => 'signup-button']
                            ) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>