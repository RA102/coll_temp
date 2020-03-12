<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupBlock */

$this->title = 'Create Rup Block';
$this->params['breadcrumbs'][] = ['label' => 'Rup Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rup-block-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formtemplate', [
        'model' => $model,
    ]) ?>

</div>
