<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ReceptionGroup */

$this->title = Yii::t('app', 'Create Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commissions'), 'url' => ['/commission']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Current Commission'), 'url' => ['/commission/current']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => ['index', 'commission_id' => $model->commission_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $this->beginBlock('content') ?>
    <div class="reception-group-create">

        <?= $this->render('_form', [
            'model' => $model,
            'specialities' => $specialities
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>