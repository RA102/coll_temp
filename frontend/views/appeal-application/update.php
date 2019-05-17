<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealApplication */
/* @var $entrans \common\models\person\Entrant[] */

$this->title = Yii::t('app', 'Update Appeal Application');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Appeal Applications'), 'url' => ['index', 'commission_id' => $model->appeal_commission_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $this->beginBlock('content') ?>
<div class="appeal-application-update">

    <?= $this->render('_form', [
        'model' => $model,
        'entrants' => $entrants
    ]) ?>

</div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>