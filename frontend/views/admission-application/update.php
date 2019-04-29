<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $admissionApplication common\models\educational_process\AdmissionApplication */
/* @var $admissionApplicationForm \frontend\models\forms\AdmissionApplicationForm */
/* @var $specialities common\models\handbook\Speciality[] */

$this->title = Yii::t('app', 'Редактировать заявление');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Заявления'), 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => $admissionApplication->id,
    'url'   => ['view', 'id' => $admissionApplication->id]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="admission-application-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'admissionApplication'     => $admissionApplication,
        'admissionApplicationForm' => $admissionApplicationForm,
        'specialities'             => $specialities
    ]) ?>

</div>
