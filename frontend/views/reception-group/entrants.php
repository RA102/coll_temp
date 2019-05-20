<?php

use common\models\person\Entrant;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use \common\models\person\Person;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\search\EntrantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Entrants');
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <h1><?=$this->title?>(<?=$dataProvider->totalCount?>)</h1>
</div>


<div class="reception-group-index skin-white">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card-body">
        <?= GridView::widget([
            'layout' =>  "{items}\n{pager}",
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'firstname',
                'lastname',
                'middlename',
                'birth_date',
                'iin',
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>