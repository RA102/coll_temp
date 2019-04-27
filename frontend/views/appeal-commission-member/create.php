<?php

/**
 * Created by PhpStorm.
 * User: azamat
 * Date: 2019-04-20
 * Time: 12:49
 */
$this->title = Yii::t('app', 'Adding member');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commissions'), 'url' => ['/commission']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Current Commission'), 'url' => ['/commission/current']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commission members'), 'url' => ['index', 'commission_id' => $model->appeal_commission_id]];
$this->params['breadcrumbs'][] = $this->title;

/* @var $this \yii\web\View */
/* @var $employeeSearch \frontend\search\EmployeeSearch */
/* @var $employeeDataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Html; ?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $this->beginBlock('content') ?>
    <div class="commission-member-create">
        <?= $this->render('_form', [
            'model' => $model,
            'roles' => $roles,
            'employees' => $employees,
        ]) ?>
    </div>

<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>