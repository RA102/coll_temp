<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealCommission */

$this->title = Yii::t('app', 'Create Appeal Commission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Appeal Commissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

<?php $this->beginBlock('content') ?>
    <div class="appeal-commission-create">

        <?= $this->render('_form', [
            'model' => $model
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>