<?php

use common\models\CountryUnit;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\components\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\person\Student */
/* @var $form frontend\models\forms\PersonContactsForm */
/* @var $activeForm yii\widgets\ActiveForm */
?>

<?php $this->beginBlock('update-content') ?>

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

    <?= $activeForm->field($form, 'contact_phone_home')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'contact_phone_mobile')->textInput(['maxlength' => true]) ?>

    <?php
    # Registration Location
    $registrationHasCountryUnit = false;
    $registrationHasStreet = false;

    echo Html::label($form->getAttributeLabel('location_registration'));
    echo $activeForm->field($form, 'registration_country_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\common\models\Country::find()->all(), 'id', 'caption_current'),
        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label(false);

    if ($form->registration_country_id) {
        $parent_id = null;
        $children = [];
        $count = 0;
        while (true) {
            $children = ArrayHelper::map(CountryUnit::find()->andWhere([
                'country_id' => $form->registration_country_id,
                'parent_id' => $parent_id,
            ])->all(), 'id', 'caption_current');
            if ($children) {
                $registrationHasCountryUnit = true;
                echo $activeForm->field($form, "registration_city_ids[{$count}]")->widget(Select2::classname(), [
                    'data' => $children,
                    'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
                    'theme' => 'default',
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label(false);

                if (isset($form->registration_city_ids[$count]) && array_key_exists($form->registration_city_ids[$count], $children)) {
                    $parent_id = $form->registration_city_ids[$count];
                    $count++;

                    continue;
                }
            }

            break;
        }

        if ($parent_id && !$children) {
            $registrationHasStreet = true;
            echo $activeForm->field($form, "registration_street_id")->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\common\models\Street::find()->andWhere(['city_id' => $parent_id])->all(), 'id', 'caption_current'),
                'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
                'theme' => 'default',
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(false);
        }
    }

    if (!$registrationHasCountryUnit) {
        echo $activeForm->field($form, 'registration_city_ids[]')->hiddenInput(['value' => null])->label(false);
    }
    if (!$registrationHasStreet) {
        echo $activeForm->field($form, "registration_street_id")->hiddenInput(['value' => null])->label(false);
    }
    ?>

    <?php
    # Residence Location
    $residenceHasCountryUnit = false;
    $residenceHasStreet = false;

    echo Html::label($form->getAttributeLabel('location_residence'));
    echo $activeForm->field($form, 'residence_country_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\common\models\Country::find()->all(), 'id', 'caption_current'),
        'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label(false);

    if ($form->residence_country_id) {
        $parent_id = null;
        $children = [];
        $count = 0;
        while (true) {
            $children = ArrayHelper::map(CountryUnit::find()->andWhere([
                'country_id' => $form->residence_country_id,
                'parent_id' => $parent_id,
            ])->all(), 'id', 'caption_current');
            if ($children) {
                $residenceHasCountryUnit = true;
                echo $activeForm->field($form, "residence_city_ids[{$count}]")->widget(Select2::classname(), [
                    'data' => $children,
                    'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
                    'theme' => 'default',
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label(false);

                if (isset($form->residence_city_ids[$count]) && array_key_exists($form->residence_city_ids[$count], $children)) {
                    $parent_id = $form->residence_city_ids[$count];
                    $count++;

                    continue;
                }
            }

            break;
        }

        if ($parent_id && !$children) {
            $residenceHasStreet = true;
            echo $activeForm->field($form, "residence_street_id")->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\common\models\Street::find()->andWhere(['city_id' => $parent_id])->all(), 'id', 'caption_current'),
                'options' => ['placeholder' => '...', 'class' => 'active-form-refresh-control'],
                'theme' => 'default',
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(false);
        }
    }

    if (!$residenceHasCountryUnit) {
        echo $activeForm->field($form, 'residence_city_ids[]')->hiddenInput(['value' => null])->label(false);
    }
    if (!$residenceHasStreet) {
        echo $activeForm->field($form, "residence_street_id")->hiddenInput(['value' => null])->label(false);
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

<?php $this->endBlock() ?>

<?= $this->render('_update_layout', ['model' => $model]) ?>
