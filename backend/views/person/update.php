<?php

/* @var $this yii\web\View */
/* @var $model common\models\person\Person */

$this->title = Yii::t('app', 'Update Person: {name}', [
    'name' => $model->getFullName(),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getFullName(), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<?php $this->beginBlock('content') ?>
<div class="person-update">

    <?= $this->render('_form', [
        'model' => $form
    ]) ?>

</div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>
