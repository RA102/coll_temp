<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupSubBlock */

$this->title = 'Update Rup Sub Block: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Rup Sub Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rup-sub-block-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
