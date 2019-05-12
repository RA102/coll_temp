<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $commission common\models\reception\Commission */


$this->title = Yii::t('app', 'Reports');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commissions'), 'url' => ['/commission/index']];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Commission'),
    'url'   => ['/commission/view', 'id' => $commission->id]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-md-4">
        <a href="<?= \yii\helpers\Url::current(['forms']) ?>">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa fa-user-tie fa-3x"></i>
                    <h4><?= Yii::t('app', 'Forms') ?></h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= \yii\helpers\Url::to(['/reception/entrance-exam-order/index', 'commission_id' => $commission->id]) ?>">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa fa-file-alt fa-3x"></i>
                    <h4><?= Yii::t('app', 'Order of admission to exams') ?></h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= \yii\helpers\Url::to(['/reception/admission-order/index', 'commission_id' => $commission->id]) ?>">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa fa-file-alt fa-3x"></i>
                    <h4><?= Yii::t('app', 'Order of admission') ?></h4>
                </div>
            </div>
        </a>
    </div>
</div>

