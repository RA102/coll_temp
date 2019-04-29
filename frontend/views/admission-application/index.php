<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Заявления');
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?= $this->title ?> (<?= $dataProvider->totalCount ?>)</h1>
    <?= Html::a(Yii::t('app', 'Add'), ['create'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="admission-application-index student-block">

    <?php Pjax::begin(); ?>

    <div class="card-body">
        <?= GridView::widget([
            'layout'       => "{items}\n{pager}",
            'dataProvider' => $dataProvider,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'status'
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
