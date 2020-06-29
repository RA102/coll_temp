<?php

use common\models\organization\InstitutionDiscipline;
use common\services\person\EmployeeService;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDiscipline */

$this->title = Yii::t('app', 'Create Institution Discipline');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Institution Disciplines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
<div class="institution-discipline-create">

    <?= $this->renderAjax('_formDiscipline', [
        'model' => new InstitutionDiscipline(),
        'teachers' => (new EmployeeService())->getTeachers(\Yii::$app->user->identity->institution),
    ]) ?>

</div>
<?php $this->endBlock() ?>
<?//= $this->render('_layout') ?>
