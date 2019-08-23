<?php

use common\models\person\Employee;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel frontend\search\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\FullcalendarAsset::register($this);
$this->title = Yii::t('app', 'Карта занятости') . ' ' . $model->fullname;
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="skin-white">
    <p><b>Часов в неделю: </b><?= $dataProvider->totalCount ?></p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

</div>

<div class="lesson-index skin-white">
    <div class="card-body">
        <div id="teacher-calendar" class="fc fc-unthemed fc-ltr"></div>
    </div>
</div>

<div class="group-index skin-white">
    <div class="card-body">
    </div>
</div>

<?php
$feedUrl = json_encode(Url::to(array_merge(['lesson/ajax-feed'], [Html::getInputName($searchModel, 'teacher_id') => $searchModel->teacher_id])));
$createUrl = json_encode(Url::to(['lesson/ajax-create']));
$deleteUrl = json_encode(Url::to(['lesson/ajax-delete']));

$this->registerJs("
var feedUrl = {$feedUrl};
var createUrl = {$createUrl};
var deleteUrl = {$deleteUrl};
", View::POS_BEGIN);
?>