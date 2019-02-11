<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Discipline */

$this->title = Yii::t('app', 'Create Discipline');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Disciplines'), 'url' => ['index']];
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
