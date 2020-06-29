<?php
use kartik\tabs\TabsX;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDiscipline */

$this->title = Yii::t('app', 'Update Institution Discipline') . ': ' . $model->caption_current;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Institution Disciplines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->caption_current, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
    <div class="institution-discipline-update">



        <?= $this->render('_form', [
            'model' => $model,
            'teachers' => $teachers,
            'departments' => $departments,
        ]) ?>


    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>