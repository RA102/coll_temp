<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Абитуриенты');
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?= $this->title ?> (<?= $dataProvider->count ?>)</h1>
</div>


<div class="entrant-index student-block">
    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],

                'firstname',
                'lastname',
                'middlename',
                'birth_date',
                //'sex',
                //'nationality_id',
                //'iin',
                //'is_pluralist',
                //'birth_country_id',
                //'birth_city_id',
                //'birth_place',
                //'language',
                //'oid',
                //'alledu_id',
                //'alledu_server_id',
                //'pupil_id',
                //'owner_id',
                //'server_id',
                //'is_subscribed:boolean',
                //'portal_uid',
                //'photo',
                //'type',
                //'create_ts',
                //'delete_ts',
                //'import_ts',
                //'person_type',

                [
                    'class'    => 'yii\grid\ActionColumn',
                    'template' => '{view}'
                ],
            ],
        ]); ?>
    </div>
</div>
