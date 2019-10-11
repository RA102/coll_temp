<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\forms\StudentGeneralForm */

$this->title = 'Создать совместителя';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Совместители', 'url' => ['pluralist']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?=$this->title?></h1>
<?php $this->beginBlock('content') ?>
    <div class="employee-create">
        <?= $this->render('_form_pluralist', [
            'model' => $model,
            'person' => $person,
            'block' => $block
        ]) ?>
    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>
