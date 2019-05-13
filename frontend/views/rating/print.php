<?php

use common\helpers\ApplicationHelper;
use common\helpers\EducationHelper;
use common\helpers\LanguageHelper;
use common\models\reception\AdmissionApplication;

/** @var \common\models\reception\Commission $commission */
/** @var $admissionApplications \common\models\reception\AdmissionApplication[] */

$this->title = Yii::t('app', 'Rating');
?>

<h4 class="text-center">
    <b>
        Рейтинги
    </b>
</h4>

<p>
    Специальность:
    <br>
    <b>
    <?php
    $speciality = \common\models\handbook\Speciality::findOne($speciality_id);
    echo $speciality ? $speciality->caption_current : '_________________________________________________';
    ?>
    </b>
</p>

<p>
    Квалификация:
    <br>
    <b>
    <?php
    $speciality = \common\models\handbook\Speciality::findOne($speciality_id);
    echo $speciality ? $speciality->caption_current : '_________________________________________________';
    ?>
    </b>
</p>

<br>


<p>
    <small>
    Форма оплаты: <?= EducationHelper::getPaymentFormTypes()[$education_pay_form] ?>
    </small>
</p>
<p>
    <small>
    База образования: <?= ApplicationHelper::getBasedClassesArray()[$based_classes] ?>
    </small>
</p>
<p>
    <small>
    Язык обучения: <?= LanguageHelper::getLanguageList()[$language] ?>
    </small>
</p>
<p>
    <small>
    Основа обучения: <?= EducationHelper::getEducationFormTypes()[$education_form] ?>
    </small>
</p>

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