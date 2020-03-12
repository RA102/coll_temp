<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\person\Student */

$this->title = $model->firstname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$action = $this->context->action->id;
?>

<div>
    <h1><?=Yii::t('app', 'View student') . ' ' . $model->getFullName() ?></h1>
</div>

<div class="student-view student-block">

    <div class="card-header">
        <ul class="nav nav-tabs">
            <li role="presentation" class="<?=$action == 'view' ? 'active' : ''?>">
                <?= Html::a(Yii::t('app', 'Personal Data'), Url::to(['/student/view/', 'id' => $model->id])) ?>
            </li>
            <li role="presentation" class="<?=$action == 'view-contacts' ? 'active' : ''?>">
                <?= Html::a(Yii::t('app', 'Contacts'), Url::to(['/student/view-contacts/', 'id' => $model->id])) ?>
            </li>
            <li role="presentation" class="<?=$action == 'view-documents' ? 'active' : ''?>">
                <?= Html::a(Yii::t('app', 'Documents'), Url::to(['/student/view-documents/', 'id' => $model->id])) ?>
            </li>
            <li role="presentation" class="<?=$action == 'view-authorization' ? 'active' : ''?>">
                <?= Html::a(
                    Yii::t('app', 'Authorization Records'),
                    Url::to(['/student/view-authorization/', 'id' => $model->id])
                ) ?>
            </li>
            <li role="presentation" class="<?=$action == 'view-relatives' ? 'active' : ''?>">
                <?= Html::a(Yii::t('app', 'Relatives'), Url::to(['/student/view-relatives/', 'id' => $model->id])) ?>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <?= $this->blocks["view-content"] ?>
    </div>

</div>