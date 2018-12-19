<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\person\Student */

$this->title = Yii::t('app', 'Update ' . $model->firstname, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->firstname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$action = $this->context->action->id;
?>

<div>
    <h1>Редактирование студента</h1>
</div>

<div class="student-view student-block">

    <div class="card-header">
        <ul class="nav nav-tabs">
            <li role="presentation" class="<?= $action == 'update' ? 'active' : '' ?>">
                <?= Html::a(Yii::t('app', 'Personal Data'), Url::to(['/student/view/', 'id' => $model->id])) ?>
            </li>
            <li role="presentation" class="<?= $action == 'update-contacts' ? 'active' : '' ?>">
                <?= Html::a(Yii::t('app', 'Contacts'), Url::to(['/student/view-contacts/', 'id' => $model->id])) ?>
            </li>
            <li role="presentation" class="<?= $action == 'update-documents' ? 'active' : '' ?>">
                <?= Html::a(Yii::t('app', 'Documents'), Url::to(['/student/view-documents/', 'id' => $model->id])) ?>
            </li>
            <li role="presentation" class="<?= $action == 'update-authorization' ? 'active' : '' ?>">
                <?= Html::a(
                    Yii::t('app', 'Authorization Records'),
                    Url::to(['/student/view-authorization/', 'id' => $model->id])
                ) ?>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <?= $this->blocks["update-content"] ?>
    </div>

</div>