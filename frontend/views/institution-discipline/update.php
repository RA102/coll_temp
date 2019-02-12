<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDiscipline */

$this->title = Yii::t('app', 'Update Institution Discipline: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Institution Disciplines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
    <div class="institution-discipline-update">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>