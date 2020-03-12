<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupSubjects */

$this->title = 'Update Rup Subjects: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Rup Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rup-subjects-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
