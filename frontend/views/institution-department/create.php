<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDepartment */

$this->title = Yii::t('app', 'Create Institution Department');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Institution Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
    <div class="institution-department-create">

        <?= $this->render('_form', [
            'model' => $model,
            'teachers' => $teachers,
            'disciplines' => $disciplines
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>
