<?php

use common\models\CountryUnit;
use common\models\Street;
use yii\helpers\Html;
use common\components\ActiveForm;
use kartik\date\DatePicker;
use common\helpers\PersonHelper;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\organization\OrganizationalLegalForm;
use common\models\organization\EducationalForm;
use common\models\Country;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionApplication */
/* @var $activeForm yii\widgets\ActiveForm */
/* @var $form \backend\models\forms\ApplicationForm */
?>

<div class="institution-application-form">
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
            <fieldset>
                <legend>ДАННЫЕ ОРГАНИЗАЦИИ</legend>
                <div class="col-md-12">
                    <?= $activeForm->field($form, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-12">
                    <?= $activeForm->field($form, 'organizational_legal_form_id')
                        ->dropDownList(ArrayHelper::map(
                            OrganizationalLegalForm::find()->all(),
                            'id',
                            'caption_current')
                        )
                    ?>
                </div>
                <div class="col-md-6">
                    <?= $activeForm->field($form, 'educational_form_id')
                        ->dropDownList(ArrayHelper::map(
                            EducationalForm::find()->all(),
                            'id',
                            'caption_current')
                        )
                    ?>
                </div>
                <div class="col-md-6">
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
                            $form->hasInstitutionType = true;
                            echo $activeForm->field($form, "type_ids[{$type_count}]")->dropDownList(
                                ArrayHelper::map($type_children, 'id', 'caption_current'), [
                                'class' => 'form-control active-form-refresh-control',
                                'prompt' => ''
                            ])->label($label);

                            if (isset($form->type_ids[$type_count]) && $form->type_ids[$type_count]) {
                                $type_parent_id = $form->type_ids[$type_count];
                                $type_count++;

                                continue;
                            }
                        }

                        break;
                    }


                    if (!$form->hasInstitutionType) {
                        echo $activeForm->field($form, 'type_ids[]')->hiddenInput(['value' => null])->label(false);
                    }

                    ?>
                </div>
            </fieldset>

            <div class="col-md-12">
                <fieldset>
                    <legend>АДРЕСНЫЕ ДАННЫЕ</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $activeForm->field($form, 'country_id')->dropDownList(
                                ArrayHelper::map(Country::find()->all(), 'id', 'caption_current'), [
                                'class' => 'form-control active-form-refresh-control',
                                'prompt' => ''
                            ]) ?>

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
                                        echo $activeForm->field($form, "city_ids[{$count}]")->dropDownList(
                                            ArrayHelper::map($children, 'id', 'caption_current'), [
                                            'class' => 'form-control active-form-refresh-control',
                                            'prompt' => ''
                                        ])->label(false);

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
                                    echo $activeForm->field($form, "street")->dropDownList(
                                        ArrayHelper::map(Street::find()->andWhere(['city_id' => $parent_id])->all(), 'id', 'caption'), [
                                        'class' => 'form-control',
                                        'prompt' => ''
                                    ]);
                                }
                                if ($parent_id && !$children && $form->hasStreet) {
                                    $form->hasHouseNumber = true;
                                    echo $activeForm->field($form, 'house_number');
                                }
                            }

                            if (!$form->hasCountryUnit) {
                                echo $activeForm->field($form, 'city_ids[]')->hiddenInput(['value' => null])->label(false);
                            }
                            if (!$form->hasStreet) {
                                echo $activeForm->field($form, "street")->hiddenInput(['value' => null])->label(false);
                            }
                            if (!$form->hasHouseNumber) {
                                echo $activeForm->field($form, "house_number")->hiddenInput(['value' => null])->label(false);
                            }

                            ?>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-12">
                <legend>КОНТАКТНЫЕ ДАННЫЕ</legend>
                <div class="row">
                    <div class="col-md-6">
                        <?= $activeForm->field($form, 'phone')
                            ->textInput()
                            ->widget(\yii\widgets\MaskedInput::class, ['mask' => '+7 (999) 999-99-99',]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $activeForm->field($form, 'email')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <legend>ДАННЫЕ ПОЛЬЗОВАТЕЛЯ</legend>
            <div class="col-md-12">
                <?= $activeForm->field($form, 'lastname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-12">
                <?= $activeForm->field($form, 'firstname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-12">
                <?= $activeForm->field($form, 'middlename')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-12">
                <?= $activeForm->field($form, 'iin')
                    ->textInput(['maxlength' => true])
                    ->widget(\yii\widgets\MaskedInput::class, ['mask' => '999999999999'])
                ?>
            </div>
            <div class="col-md-12">
                <?= $activeForm->field($form, 'birth_date')->widget(DatePicker::class, [
                    'language' => 'ru',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]); ?>
            </div>
            <div class="col-md-12">
                <?= $activeForm->field($form, 'sex')->dropDownList(PersonHelper::getSexList()) ?>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-12">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
