<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\reception\Commission */

$this->title = Yii::t('app', 'Create Commission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="alert-success alert fade in">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <ul class="mb-0">
        <li>
            <strong class="field">Название комиссии</strong>: Для создания новой комиссии необходимо ввести ее название
        </li>
        <li>
            <strong class="field">Сроки комиссии</strong>: Сроки проведения ограничены датами начала и окончания комиссии
        </li>
    </ul>

</div>

<div class="card">
    <div class="card-body">
        <div class="commission-create">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
