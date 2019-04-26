<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ReceptionExam */
/* @var $teachers common\models\person\Employee[] */
/* @var $institutionDisciplines common\models\organization\InstitutionDiscipline[] */

$this->title = Yii::t('app', 'Create Reception Exam');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reception Exams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="card">
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
            'teachers' => $teachers,
            'institutionDisciplines' => $institutionDisciplines,
        ]) ?>
    </div>
</div>
