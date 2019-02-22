<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel frontend\search\LessonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\FullcalendarAsset::register($this);
$this->title = Yii::t('app', 'Lessons');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div style="position: relative;">
        <h1><?= $this->title ?></h1>
        <?= Html::a('Добавить', ['create'], ['class' => 'title-action btn btn-primary']) ?>
    </div>

    <div class="lesson-index skin-white">

        <div class="card-body">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <div id="calendar" class="fc fc-unthemed fc-ltr"></div>
        </div>
    </div>

<?php
$url = json_encode(Url::to(array_merge(
            ['lesson/ajax-feed'],
            \Yii::$app->request->getQueryParams()
        )));
$this->registerJs('var feedUrl = ' . $url . ';', View::POS_BEGIN);
?>