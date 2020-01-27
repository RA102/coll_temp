<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\rup\RupQualifications */

$this->title = 'Create Rup Qualifications';
$this->params['breadcrumbs'][] = ['label' => 'Rup Qualifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rup-qualifications-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
