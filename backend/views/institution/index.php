<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\InstitutionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Institutions');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content') ?>
    <div class="institution-index">
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
//                'country_id',
                'city_id',
                'parent_id',
                //'type_id',
                'educational_form_id',
                //'organizational_legal_form_id',
                //'oid',
                //'server_id',
                //'street_id',
                //'house_number',
                //'phone',
                //'fax',
                //'email:email',
                //'languages_iso',
                //'description:ntext',
                //'bin',
                //'foundation_year',
                //'website',
                //'max_grade',
                //'info:ntext',
                //'domain',
                //'db_name',
                //'db_user',
                //'db_password',
                //'initialization:boolean',
                //'status',
                //'create_ts',
                //'update_ts',
                //'delete_ts',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('tools') ?>
<?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['create'], ['class' => 'btn btn-default']) ?>
<?php $this->endBlock() ?>

<?= $this->render('_layout') ?>