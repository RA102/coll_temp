<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionApplication */

$this->title = Yii::t('app', 'New Application');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Institution Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('content') ?>
    <div class="institution-application-create">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>