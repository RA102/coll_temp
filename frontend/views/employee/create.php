<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\forms\StudentGeneralForm */

$this->title = Yii::t('app', 'Create Employee');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content') ?>
    <div class="employee-create">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>
