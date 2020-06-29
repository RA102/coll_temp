<?php
use common\models\organization\InstitutionDiscipline;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDepartment */

$this->title = Yii::t('app', 'Update Institution Department') . ': ' . $model->caption_current;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Institution Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->caption_current];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

    <h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
    <div class="institution-department-update">

        <?= $this->render('_form', [
            'model' => $model,
            'disciplines' => $disciplines
        ]) ?>

    </div>

<?php ?>

<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>

