<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\reception\Commission */

$this->title = Yii::t('app', 'Update Commission') . ': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->caption_current, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="card">
    <div class="card-body">
        <div class="commission-create">
            <?= $this->render('_form', [
                'form' => $form,
            ]) ?>
        </div>
    </div>
</div>