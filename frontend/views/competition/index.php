<?php

use common\helpers\ApplicationHelper;
use common\helpers\EducationHelper;
use yii\helpers\Html;

/** @var string $commission_id */

$this->title = Yii::t('app', 'Competitions');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Commissions'),
    'url'   => ['commission/index']
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Commission'),
    'url'   => ['commission/view', 'id' => $commission_id]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?= $this->title ?></h1>
</div>

<div class="card">
    <div class="card-body">
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns'      => [
                [
                    'label' => Yii::t('app', 'Speciality ID'),
                    'value' => 'speciality.caption_current',
                ],
                [
                    'label' => Yii::t('app', 'Форма оплаты'),
                    'value' => function (array $competitionData) {
                        return EducationHelper::getPaymentFormTypes()[$competitionData['education_pay_form']];
                    }
                ],
                [
                    'label' => Yii::t('app', 'Язык обучения'),
                    'value' => function (array $competitionData) {
                        return \common\helpers\LanguageHelper::getLanguageList()[$competitionData['language']];
                    }
                ],
                [
                    'label' => Yii::t('app', 'Основа обучения'),
                    'value' => function (array $competitionData) {
                        return EducationHelper::getEducationFormTypes()[$competitionData['education_form']];
                    }
                ],
                [
                    'label' => Yii::t('app', 'На базе'),
                    'value' => function (array $competitionData) {
                        return ApplicationHelper::getBasedClassesLabel($competitionData['based_classes']);
                    }
                ],
                [
                    'label' => Yii::t('app', 'Количество мест'),
                    'value' => function (array $competitionData) {
                        return '-';
                    }
                ],
                [
                    'label' => Yii::t('app', 'Количество зачисленных'),
                    'value' => function (array $competitionData) {
                        return $competitionData['enlisted_count'];
                    }
                ],
                [
                    'class'      => 'yii\grid\ActionColumn',
                    'controller' => 'competition',
                    'buttons'    => [
                        'view' => function ($url, $competitionData, $key) use ($commission_id) {
                            $id = str_replace(':', '/', $key);
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                                "view/{$commission_id}/{$id}");
                        }
                    ],
                    'template'   => '{view}',
                ]
            ]
        ]); ?>
    </div>
</div>
