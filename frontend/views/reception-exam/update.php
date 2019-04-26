<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ReceptionExam */
/* @var $teachers common\models\person\Employee[] */
/* @var $institutionDisciplines common\models\organization\InstitutionDiscipline[] */

$this->title = Yii::t('app', 'Update Reception Exam: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reception Exams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="reception-exam-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'teachers' => $teachers,
        'institutionDisciplines' => $institutionDisciplines,
    ]) ?>

</div>
