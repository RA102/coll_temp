<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\person\Employee */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Institutions'), 'url' => ['all']];
$this->params['breadcrumbs'][] = $model->name;
$action = $this->context->action->id;
?>

<div>
    <h1><?=$this->title?></h1>
</div>

<div class="employee-view student-block">

    <div class="card-header">
        <ul class="nav nav-tabs">
            <li role="presentation" class="<?=$action == 'view' ? 'active' : ''?>">
                <?= Html::a(Yii::t('app', 'Contacts'), Url::to(['/institution/view/', 'id' => $model->id])) ?>
            </li>
            <li role="presentation" class="<?=$action == 'view-committee' ? 'active' : ''?>">
                <?= Html::a(Yii::t('app', 'Selection committee'), Url::to(['/institution/view-committee/', 'id' => $model->id])) ?>
            </li>
            <li role="presentation" class="<?=$action == 'view-employees' ? 'active' : ''?>">
                <?= Html::a(Yii::t('app', 'Employees'), Url::to(['/institution/view-employees/', 'id' => $model->id])) ?>
            </li>
            <li role="presentation" class="<?=$action == 'view-students' ? 'active' : ''?>">
                <?= Html::a(
                    Yii::t('app', 'Students'),
                    Url::to(['/institution/view-students/', 'id' => $model->id])
                ) ?>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <?= $this->blocks["view-content"] ?>
    </div>

</div>