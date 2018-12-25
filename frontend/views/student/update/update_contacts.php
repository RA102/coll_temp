<?php

use common\models\CountryUnit;
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

    <?= $activeForm->field($form, 'residence_country_id')->dropDownList(
        ArrayHelper::map(\common\models\Country::find()->all(), 'id', 'name'), [
            'class' => 'form-control active-form-refresh-control',
            'prompt' => ''
        ]) ?>

    <?php
    if ($form->residence_country_id) {
        $parent_id = null;
        $children = [];
        $count = 0;
        while (true) {
            $children = CountryUnit::find()->andWhere([
                'country_id' => $form->residence_country_id,
                'parent_id' => $parent_id,
            ])->all();
            if ($children) {
                $form->hasCountryUnit = true;
                echo $activeForm->field($form, "residence_city_ids[{$count}]")->dropDownList(
                    ArrayHelper::map($children, 'id', 'name'), [
                    'class' => 'form-control active-form-refresh-control',
                    'prompt' => ''
                ]);

                if (isset($form->residence_city_ids[$count]) && $form->residence_city_ids[$count]) {
                    $parent_id = $form->residence_city_ids[$count];
                    $count++;

                    continue;
                }
            }

            break;
        }

        if ($parent_id && !$children) {
            $form->hasStreet = true;
            echo $activeForm->field($form, "residence_street_id")->dropDownList(
                ArrayHelper::map(\common\models\Street::find()->andWhere(['city_id' => $parent_id])->all(), 'id', 'caption'), [
                'class' => 'form-control',
                'prompt' => ''
            ]);
        }
    }

    if (!$form->hasCountryUnit) {
        echo $activeForm->field($form, 'residence_city_ids[]')->hiddenInput(['value' => null])->label(false);
    }
    if (!$form->hasStreet) {
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
