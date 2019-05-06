<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealApplication */

$this->title = Yii::t('app', 'Create Appeal Application');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Appeal Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $this->beginBlock('content') ?>
    <div class="appeal-application-create">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>