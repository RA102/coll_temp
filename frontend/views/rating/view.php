<?php

use common\helpers\ApplicationHelper;
use common\helpers\EducationHelper;
use common\helpers\LanguageHelper;
use common\models\reception\AdmissionApplication;

/** @var \common\models\reception\Commission $commission */
/** @var $admissionApplications \common\models\reception\AdmissionApplication[] */

$this->title = Yii::t('app', 'Rating');

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Commissions'),
    'url'   => ['commission/index']
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Commission'),
    'url'   => ['commission/view', 'id' => $commission->id]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Ratings'),
    'url'   => ['rating/index', 'commission_id' => $commission->id]
];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div style="position: relative;">
        <h1><?= $this->title ?></h1>
        <?= \yii\helpers\Html::a('Распечатать', [
            'print',
            'commission_id' => $commission->id,
            'speciality_id' => $speciality_id,
            'education_pay_form' => $education_pay_form,
            'language' => $language,
            'education_form' => $education_form,
            'based_classes' => $based_classes,
        ], [
            'class' => 'title-action btn btn-primary',
        ]); ?>
    </div>

    <div class="card">
        <div class="card-body">
            <?= \yii\widgets\DetailView::widget([
                'model'      => new \common\models\ReceptionGroup(),
                'attributes' => [
                    [
                        'attribute' => 'speciality_id',
                        'value'     => function ($model) use ($speciality_id) {
                            $speciality = \common\models\handbook\Speciality::findOne($speciality_id);
                            return $speciality ? $speciality->caption_current : null;
                        }
                    ],
                    [
                        'attribute' => 'education_pay_form',
                        'value'     => EducationHelper::getPaymentFormTypes()[$education_pay_form]
                    ],
                    [
                        'attribute' => 'language',
                        'value'     => LanguageHelper::getLanguageList()[$language]
                    ],
                    [
                        'attribute' => 'education_form',
                        'value'     => EducationHelper::getEducationFormTypes()[$education_form]
                    ],
                    [
                        'attribute' => 'based_classes',
                        'value'     => ApplicationHelper::getBasedClassesArray()[$based_classes]
                    ],
                    [
                        'label' => 'Проходной балл',
                        'value' => '',
                    ]
                ]
            ]) ?>

            <?= \yii\grid\GridView::widget([
                'layout' => "{items}\n{pager}",
                'dataProvider' => new \yii\data\ArrayDataProvider([
                    'models' => $admissionApplications
                ]),
                'columns'      => [
                    [
                        'label' => Yii::t('app', 'Ф.И.О'),
                        'value' => 'person.fullName'
                    ],
                    [
                        'label' => Yii::t('app', 'Баллы'),
                        'value' => function (AdmissionApplication $admissionApplication) {
                            return $admissionApplication->person->getReceptionExamGrades()->sum('points::INT');
                        }
                    ],
                    [
                        'label' => Yii::t('app', 'Допуск к конкурсу'),
                        'value' => function (AdmissionApplication $admissionApplication) {
                            return '';
                        }
                    ],
                ]
            ]);
            ?>
        </div>
    </div>