<?php

use common\helpers\ApplicationHelper;
use common\helpers\EducationHelper;
use yii\helpers\Html;

/** @var \common\models\reception\Commission $commission */

$this->title = Yii::t('app', 'Ratings');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Commissions'),
    'url'   => ['commission/index']
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Commission'),
    'url'   => ['commission/view', 'id' => $commission->id]
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
                    'value' => function (\common\models\ReceptionGroup $model) {
                        return $model->speciality->caption_current ?? null;
                    },
                ],
                [
                    'label' => Yii::t('app', 'Форма оплаты'),
                    'value' => function (\common\models\ReceptionGroup $model) {
                        return EducationHelper::getPaymentFormTypes()[$model->getEducationPayForm()['education_pay_form']];
                    }
                ],
                [
                    'label' => Yii::t('app', 'Язык обучения'),
                    'value' => function (\common\models\ReceptionGroup $model) {
                        return \common\helpers\LanguageHelper::getLanguageList()[$competitionData['language']];
                    }
                ],
                [
                    'label' => Yii::t('app', 'Основа обучения'),
                    'value' => function (\common\models\ReceptionGroup $model) {
                        return EducationHelper::getEducationFormTypes()[$competitionData['education_form']];
                    }
                ],
                [
                    'label' => Yii::t('app', 'На базе'),
                    'value' => function (\common\models\ReceptionGroup $model) {
                        return ApplicationHelper::getBasedClassesLabel($competitionData['based_classes']);
                    }
                ],
                [
                    'label' => Yii::t('app', 'Количество абитуриентов'),
                    'value' => function (\common\models\ReceptionGroup $model) {
                        return $competitionData['total_count'];
                    }
                ],
                [
                    'class'      => 'yii\grid\ActionColumn',
                    'controller' => 'competition',
                    'buttons'    => [
                        'view' => function ($url, $competitionData, $key) use ($commission) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', [
                                'view',
                                'commission_id' => $commission->id,
                                'speciality_id' => $competitionData['speciality_id'],
                                'education_pay_form' => $competitionData['education_pay_form'],
                                'language' => $competitionData['language'],
                                'education_form' => $competitionData['education_form'],
                                'based_classes' => $competitionData['based_classes'],
                            ]);
                        }
                    ],
                    'template'   => '{view}',
                ]
            ]
        ]); ?>
    </div>
</div>
