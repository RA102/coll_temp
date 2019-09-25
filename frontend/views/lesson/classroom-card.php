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
$this->title = Yii::t('app', 'Карта занятости') . ' ' . $model->number;
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
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
$feedUrl = json_encode(Url::to(array_merge(['lesson/ajax-feed'], [Html::getInputName($searchModel, 'classroom_id') => $searchModel->classroom_id])));
$createUrl = json_encode(Url::to(['lesson/ajax-create']));
$deleteUrl = json_encode(Url::to(['lesson/ajax-delete']));

$this->registerJs("
var feedUrl = {$feedUrl};
var createUrl = {$createUrl};
var deleteUrl = {$deleteUrl};
", View::POS_BEGIN);
?>