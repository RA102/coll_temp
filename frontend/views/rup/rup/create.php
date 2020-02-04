<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\rup\RupRoots */

$this->title = 'Создать РУП';
$this->params['breadcrumbs'][] = ['label' => 'РУПы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="rup-roots-create">
    <div class="card-body skin-white">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>