<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\reception\Commission */

$this->title = Yii::t('app', 'Current Commission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
    <div class="commission-current">
        <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-warning">
            У вас еще нет приемной комиссии. Создать?
        </div>
        <div class="text-right">
            <a href="<?= \yii\helpers\Url::to(['commission/create']) ?>" class="btn btn-secondary" target="_self">Создать</a>
        </div>
    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>