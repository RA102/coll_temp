<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\components\ActiveForm;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Specialities');
$this->params['breadcrumbs'][] = $this->title;

/** @var $model \frontend\models\forms\AddSpecialityForm */
/** @var $specialityInfos \common\models\organization\InstitutionSpecialityInfo [] */
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>


<div class="specialities-index" style="background-color: #FFF;">
    <?php
    Pjax::begin([
        'id' => 'list-pjax',
        'formSelector' => '#js-update',
        'scrollTo' => 'false',
    ]);
    ?>
    <div class="card-header" style="padding: 20px 20px">
        <div>Поиск специальности</div>
    </div>
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'id' => 'js-update',
            'enableClientValidation' => false,
            'options' => [
                'validateOnSubmit' => true,
            ],
        ]); ?>

        <?php
        $parent_id = null;
        $children = [];
        $count = 0;
        while (true) {
            $children = \common\models\handbook\Speciality::find()->andWhere([
                'parent_id' => $parent_id,
            ])->all();
            if ($children) {
                $label = false;
                if ($count === 0) {
                    $label = 'Профиль образования';
                    $prompt = 'Выберите профиль образования';
                } else if ($count === 1) {
                    $label = 'Специальность';
                } else if ($count === 2) {
                    $label = 'Квалификация';
                }
                $model->hasSpecialityId = true;
                echo $form->field($model, "speciality_ids[{$count}]")->dropDownList(
                    ArrayHelper::map($children, 'id', 'caption_current'), [
                    'class' => 'form-control active-form-refresh-control',
                    'prompt' => ''
                ])->label($label);

                if (isset($model->speciality_ids[$count]) && $model->speciality_ids[$count]) {
                    $parent_id = $model->speciality_ids[$count];
                    $count++;

                    continue;
                }
            } else {
                ?>
                <button class="btn btn-success pull-right" name="AddSpecialityForm[is_submitted]" value="1" type="submit">
                    Добавить
                </button>
                <div style="clear: both;"></div>
            <?}

            break;
        }


        if (!$model->hasSpecialityId) {
            echo $form->field($model, 'speciality_ids[]')->hiddenInput(['value' => null])->label(false);
        }

        ?>

        <?php ActiveForm::end(); ?>

        <hr>
        <div>
            <strong>Привязанные квалификации</strong>
            <div class="row">
                <div class="col">
                    <?php foreach($specialityInfos as $specialityInfo):?>
                    <div class="row speciality align-items-center py-2">
                        <div class="col">
                            <?="{$specialityInfo->speciality->code} - {$specialityInfo->speciality->caption_current}"?>
                        </div>
                        <div class="col-auto">
                            <?= Html::a(Html::tag('i', '', ['class' => 'far fa-trash-alt']),
                                ['/speciality/unlink', 'id' => $specialityInfo->id], [
                                    'data-method' => 'POST',
                                    'data-confirm' => "Удалить?",
                                    'data-params' => [
                                        'id' => $specialityInfo->id,
                                    ],
                                    'data-pjax' => '#list-pjax',
                                    'class' => 'btn text-white btn-danger btn-sm'
                                ]) ?>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>