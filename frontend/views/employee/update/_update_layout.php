<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\person\Employee */

$this->title = Yii::t('app', 'Update ' . $model->firstname, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->firstname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$action = $this->context->action->id;
?>

<div>
    <h1>Редактирование сотрудника</h1>
</div>

<div class="employee-view student-block">

    <div class="card-header">
        <ul class="nav nav-tabs">
            <li role="presentation" class="<?= $action == 'update' ? 'active' : '' ?>">
                <?= Html::a(Yii::t('app', 'Personal Data'), Url::to(['/employee/view/', 'id' => $model->id])) ?>
            </li>
            <li role="presentation" class="<?= $action == 'update-contacts' ? 'active' : '' ?>">
                <?= Html::a(Yii::t('app', 'Contacts'), Url::to(['/employee/view-contacts/', 'id' => $model->id])) ?>
            </li>
            <li role="presentation" class="<?= $action == 'update-documents' ? 'active' : '' ?>">
                <?= Html::a(Yii::t('app', 'Documents'), Url::to(['/employee/view-documents/', 'id' => $model->id])) ?>
            </li>
            <li role="presentation" class="<?= $action == 'update-authorization' ? 'active' : '' ?>">
                <?= Html::a(
                    Yii::t('app', 'Authorization Records'),
                    Url::to(['/employee/view-authorization/', 'id' => $model->id])
                ) ?>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <?= $this->blocks["update-content"] ?>
    </div>

</div>