<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Discipline */

$this->title = 'Update Discipline: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Disciplines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<?php $this->beginBlock('content') ?>
    <div class="discipline-update">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>
