<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealApplication */

$this->title = Yii::t('app', 'Update Appeal Application');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Appeal Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $this->beginBlock('content') ?>
<div class="appeal-application-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>