<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionApplication */

$this->title = Yii::t('app', 'Update Institution Application') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Institution Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<?php $this->beginBlock('content') ?>
    <div class="institution-application-update">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>