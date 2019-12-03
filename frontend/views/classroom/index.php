<?php

use common\helpers\ApplicationHelper;
use common\models\reception\AdmissionApplication;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \frontend\search\AdmissionApplicationSearch */

$this->title = Yii::t('app', 'Аудитории');
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?= $this->title ?> (<?= $dataProvider->totalCount ?>)</h1>
    <?= Html::a(Yii::t('app', 'Добавить'), ['create'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="admission-application-index student-block">

    <div class="card-body">
        <?= GridView::widget([
            'layout'       => "{items}\n{pager}",
            'dataProvider' => $dataProvider,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],
                'number',
                'name',
                [
                    'class'    => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ]
            ],
        ]); ?>
    </div>
</div>
