<?php


/* @var $commission \common\models\reception\Commission */
/* @var $competitionEntrantsForm \frontend\models\forms\CompetitionEntrantsForm */
/* @var $enlistEntrantForm \frontend\models\forms\EnlistEntrantForm */

/* @var $groups array */

use common\helpers\ApplicationHelper;
use common\helpers\EducationHelper;
use common\helpers\LanguageHelper;
use common\models\reception\AdmissionApplication;
use frontend\models\forms\CompetitionEntrantsForm;

/* @var $admissionApplications \common\models\reception\AdmissionApplication[] */
$this->title = Yii::t('app', 'Competition');

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Commissions'),
    'url'   => ['commission/index']
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Commission'),
    'url'   => ['commission/view', 'id' => $commission->id]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Competitions'),
    'url'   => ["competition/{$commission->id}"]
];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div style="position: relative;">
        <h1><?= $this->title ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <?= \yii\widgets\DetailView::widget([
                'model'      => $competitionEntrantsForm,
                'attributes' => [
                    [
                        'attribute' => 'speciality_id',
                        'value'     => function (CompetitionEntrantsForm $competitionEntrantsForm) {
                            $speciality = $competitionEntrantsForm->getSpeciality();
                            return $speciality ? $speciality->caption_current : null;
                        }
                    ],
                    [
                        'attribute' => 'education_pay_form',
                        'value'     => EducationHelper::getPaymentFormTypes()[$competitionEntrantsForm->education_pay_form]
                    ],
                    [
                        'attribute' => 'language',
                        'value'     => LanguageHelper::getLanguageList()[$competitionEntrantsForm->language]
                    ],
                    [
                        'attribute' => 'education_form',
                        'value'     => EducationHelper::getEducationFormTypes()[$competitionEntrantsForm->education_form]
                    ],
                    [
                        'attribute' => 'based_classes',
                        'value'     => ApplicationHelper::getBasedClassesArray()[$competitionEntrantsForm->based_classes]
                    ],
                    [
                        'label' => Yii::t('app', 'Абитуриентов в группе'),
                        'value' => sizeof($admissionApplications)
                    ]
                ]
            ]) ?>

            <?= \yii\grid\GridView::widget([
                'dataProvider' => new \yii\data\ArrayDataProvider([
                    'models' => $admissionApplications
                ]),
                'columns'      => [
                    [
                        'label' => Yii::t('app', 'Ф.И.О'),
                        'value' => 'person.fullName'
                    ],
                    [
                        'label' => Yii::t('app', 'Оценка'),
                        'value' => function (AdmissionApplication $admissionApplication) {
                            return $admissionApplication->person->getReceptionExamGrades()->sum('points');
                        }
                    ],
                    [
                        'class'    => 'yii\grid\ActionColumn',
                        'template' => '{enlist}',
                        'buttons'  => [
                            'enlist' => function ($url, AdmissionApplication $admissionApplication, $key) {
                                return \yii\helpers\Html::button(
                                    Yii::t('app', 'Зачислить'),
                                    [
                                        'class'                         => 'btn btn-success btn-xs',
                                        'data-toggle'                   => 'modal',
                                        'data-target'                   => '#enlist-admission-application-modal',
                                        'data-admission-application-id' => $admissionApplication->id
                                    ]
                                );
                            }
                        ]
                    ]
                ]
            ]);
            ?>
        </div>
    </div>

<?= $this->render('_enlist_entrant_form', [
    'enlistEntrantForm' => $enlistEntrantForm,
    'groups'            => $groups
]); ?>