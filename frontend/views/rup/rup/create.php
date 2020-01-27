<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\rup\RupRoots */

$this->title = 'Create Rup Roots';
$this->params['breadcrumbs'][] = ['label' => 'Rup Roots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rup-roots-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
