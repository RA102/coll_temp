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
    <?= Html::a(Yii::t('app', 'Добавить'), ['create'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="admission-application-index student-block">

    <?php Pjax::begin(); ?>

    <div class="card-body">
        <?= GridView::widget([
            'layout'       => "{items}\n{pager}",
            'dataProvider' => $dataProvider,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => Yii::t('app', 'Ф.И.О'),
                    'value' => 'person.fullname'
                ],
                [
                    'label' => Yii::t('app', 'Дата подачи'),
                    'value' => 'properties.application_date',
                ],
                'person.iin',
                'status',

                [
                    'class'    => 'yii\grid\ActionColumn',
                    'template' => '{view} {update}',
                ]
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
