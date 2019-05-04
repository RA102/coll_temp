<?php

use common\helpers\ApplicationHelper;
use common\helpers\EducationHelper;
use common\models\Country;
use common\models\educational_process\AdmissionApplication;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\educational_process\AdmissionApplication */
$citizenshipLocationCountry = $model->properties['citizenship_location']
    ? Country::findOne($model->properties['citizenship_location'])
    : null;
$arrivalLocationCountry = $model->properties['arrival_location']
    ? Country::findOne($model->properties['arrival_location'])
    : null;
?>

<?= DetailView::widget([
    'model'      => $model,
    'attributes' => [
        'person.iin',
        [
            'attribute' => 'properties.citizenship_location',
            'label'     => Yii::t('app', 'Гражданство'),
            'value'     => $citizenshipLocationCountry ? $citizenshipLocationCountry->caption_current : null,
        ],
        [
            'attribute' => 'person.firstname',
            'value'     => function (AdmissionApplication $admissionApplication) {
                return $admissionApplication->person->getFullName();
            }
        ],
        [
            'attribute' => 'person.sex',
            'value'     => function (AdmissionApplication $admissionApplication) {
                return $admissionApplication->person->getSex();
            }
        ],
        'person.birth_date',
        [
            'attribute' => 'properties.application_date',
            'label'     => Yii::t('app', 'Дата подачи'),
            'value'     => $model->properties['application_date'],
        ],
        [
            'attribute' => 'person.nationality_id',
            'value'     => function (AdmissionApplication $admissionApplication) {
                return $admissionApplication->person->nationality->name ?? null;
            }
        ],
        [
            'attribute' => 'properties.is_repatriate',
            'format'    => 'boolean',
            'label'     => Yii::t('app', 'Оралман/Беженец'),
        ],
        [
            'attribute'      => 'properties.arrival_location',
            'value'          => $arrivalLocationCountry ? $arrivalLocationCountry->caption_current : null,
            'label'          => Yii::t('app', 'Откуда приехал'),
            'captionOptions' => [
                'class' => $model->properties['is_repatriate'] ? '' : 'hidden'
            ],
            'contentOptions' => [
                'class' => $model->properties['is_repatriate'] ? '' : 'hidden'
            ]
        ],

        [
            'label' => Yii::t('app', 'Speciality ID'),
            'value' => 'specialityName',
        ],
        [
            'label' => Yii::t('app', 'Форма оплаты'),
            'value' => function (AdmissionApplication $admissionApplication) {
                return EducationHelper::getPaymentFormTypes()[$admissionApplication->properties['education_pay_form']];
            }
        ],
        [
            'label' => Yii::t('app', 'Язык обучения'),
            'value' => function (AdmissionApplication $admissionApplication) {
                return \common\helpers\LanguageHelper::getLanguageList()[$admissionApplication->properties['language']];
            }
        ],
        [
            'label' => Yii::t('app', 'Основа обучения'),
            'value' => function (AdmissionApplication $admissionApplication) {
                return EducationHelper::getEducationFormTypes()[$admissionApplication->properties['education_form']];
            }
        ],
        [
            'label' => Yii::t('app', 'На базе'),
            'value' => function (AdmissionApplication $admissionApplication) {
                return ApplicationHelper::getBasedClassesLabel($admissionApplication->properties['based_classes']);
            }
        ],
    ],
]); ?>

<?= $this->render('_actions', compact('model')); ?>
