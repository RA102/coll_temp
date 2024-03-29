<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use common\components\ActiveForm;
use common\models\organization\InstitutionSpecialityInfo;

$this->title = Yii::t('app', 'Specialities');
$this->params['breadcrumbs'][] = $this->title;

/** @var $model \frontend\models\forms\AddSpecialityForm */
/** @var $specialityInfos \common\models\organization\InstitutionSpecialityInfo [] */
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>


    <div class="card-header" style="padding: 20px 20px">
        <div>Поиск специальности</div>
    </div>
    <div class="card-body skin-white">
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

                echo $form->field($model, "speciality_ids[{$count}]")->widget(Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map($children, 'id', function (\common\models\handbook\Speciality $model) {
                        return $model->getCaptionWithCode();
                    }),
                    'options' => ['placeholder' => '', 'class' => "form-control active-form-refresh-control"],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
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
            <?php }

            break;
        }


        if (!$model->hasSpecialityId) {
            echo $form->field($model, 'speciality_ids[]')->hiddenInput(['value' => null])->label(false);
        }

        ?>

        <?php ActiveForm::end(); ?>

        <!-- <div>
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
        </div> -->

    </div>

    <br>

    <div class="card-body skin-white">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                
                [
                    'attribute' => 'code',
                    'value' => function (InstitutionSpecialityInfo $model) {
                        return $model->speciality->code;
                    },
                    'label' => 'Код'
                ],

                [
                    'attribute' => 'caption',
                    'value' => function (InstitutionSpecialityInfo $model) {
                        return $model->speciality->caption_current;
                    },
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function($url, $model, $key) {
                            return Html::a(Html::tag('i', '', ['class' => 'far fa-trash-alt']),
                                ['/speciality/unlink', 'id' => $model->id], [
                                    'data-method' => 'POST',
                                    'data-confirm' => "Удалить?",
                                    'data-params' => [
                                        'id' => $model->id,
                                    ],
                                    'data-pjax' => '#list-pjax',
                                    'class' => 'btn text-white btn-danger btn-sm'
                                ]);
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>
