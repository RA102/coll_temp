<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupModule */

$this->title = 'Create Rup Module';
$this->params['breadcrumbs'][] = ['label' => 'Rup Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rup-module-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
