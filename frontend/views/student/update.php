<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\forms\PersonGeneralForm */
/* @var $person common\models\person\Person */

$this->title = Yii::t('app', 'Update Student: ' . $person->id, [
    'nameAttribute' => '' . $person->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $person->id, 'url' => ['view', 'id' => $person->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<?php $this->beginBlock('content') ?>
    <div class="person-update">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>