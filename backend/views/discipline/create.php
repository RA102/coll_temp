<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Discipline */

$this->title = 'Create Discipline';
$this->params['breadcrumbs'][] = ['label' => 'Disciplines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('content') ?>
    <div class="discipline-create">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
<?php $this->endBlock(); ?>
<?= $this->render('_layout') ?>
