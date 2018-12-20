<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\InstitutionApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Institution Applications');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institution-application-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Institution Application'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'iin',
            'sex',
            'email:email',
            'phone',
            //'name',
            //'city_id',
            //'type_id',
            //'firstname',
            //'lastname',
            //'middlename',
            //'street',
            //'birth_date',
            //'house_number',
            //'educational_form_id',
            //'organizational_legal_form_id',
            //'status',
            //'create_ts',
            //'update_ts',
            //'delete_ts',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
