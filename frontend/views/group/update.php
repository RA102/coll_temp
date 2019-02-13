<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\organization\Group */
/* @var $specialities \common\models\handbook\Speciality[] */

$this->title = Yii::t('app', 'Update Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
    <div class="group-update">

        <?= $this->render('_form', [
            'model' => $model,
            'specialities' => $specialities,
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>