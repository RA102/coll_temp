<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\person\Person */

$this->title = Yii::t('app', 'Create Student');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content') ?>
    <div class="person-create">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>
