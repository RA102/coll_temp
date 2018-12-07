<?php

/* @var $this yii\web\View */
/* @var $model common\models\organization\Institution */

$this->title = Yii::t('app', 'Create Institution');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Institutions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content') ?>
    <div class="institution-create">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>