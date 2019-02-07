<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\handbook\Speciality */

$this->title = Yii::t('app', 'New Speciality');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Specialities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speciality-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
