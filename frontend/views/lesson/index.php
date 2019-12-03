<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\search\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Расписание');
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="group-index skin-white">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <a href="/lesson/groups">Группы</a>
            </div>
            <div class="col-md-3">
                <a href="/lesson/teachers">Карты занятости преподавателей</a>
            </div>
            <div class="col-md-3">
                <a href="/lesson/classrooms">Карты занятости аудиторий</a>
            </div>
        </div>
    </div>
</div>
