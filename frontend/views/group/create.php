<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\organization\Group */

$this->title = Yii::t('app', 'Create Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
<div class="group-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>