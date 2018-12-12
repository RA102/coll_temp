<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\forms\StudentGeneralForm */
/* @var $student common\models\person\Student */

$this->title = Yii::t('app', 'Update Student: ' . $student->id, [
    'nameAttribute' => '' . $student->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $student->id, 'url' => ['view', 'id' => $student->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<?php $this->beginBlock('content') ?>
    <div class="student-update">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>