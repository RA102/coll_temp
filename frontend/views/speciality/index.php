<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\components\ActiveForm;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Specialities');
$this->params['breadcrumbs'][] = $this->title;

/** @var $model \frontend\models\forms\AddSpecialityForm */
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
    <?php $form = ActiveForm::begin([
        'id' => 'js-update',
        'enableClientValidation' => false,
        'options' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>
    <div class="card-header" style="padding: 20px 20px">
        <div>Поиск специальности</div>
    </div>
    <div class="card-body">
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
    </div>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>