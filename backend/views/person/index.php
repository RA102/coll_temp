<?php

use common\helpers\InstitutionHelper;
use common\helpers\PersonTypeHelper;
use common\models\organization\Institution;
use common\models\person\Person;
use common\models\person\PersonCredential;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Пользователи');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('content') ?>
    <div class="person-index" style="overflow: scroll">
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'firstname',
                'lastname',
                'middlename',
                [
                    'format' => 'html',
                    'header' => 'Логин',
                    'attribute' => 'indentity',
                    'value' => function (Person $model) {
                        return implode('<hr/>', array_map(function (PersonCredential $model) {
                            return $model->indentity;
                        }, $model->personCredentials));
                    }
                ],
                'iin',
                [
                    'format' => 'html',
                    'header' => 'Колледж',
                    'contentOptions' => ['style' => 'width:300px; word-wrap: break-word; overflow: hidden;'],
                    'attribute' => 'institution_filter',
                    'filter' => InstitutionHelper::getList(),
                    'value' => function (Person $model) {
                        return implode('<hr/>', array_map(function (Institution $model) {
                            return $model->name;
                        }, $model->institutions));
                    }
                ],
                [
                    'filter' => \common\helpers\PersonHelper::getStatusList(),
                    'attribute' => 'status',
                    'value' => function (Person $model) {
                        $status = \common\helpers\PersonHelper::getStatusList();
                        return $status[$model->status] ?? 'unknown';
                    },
                ],
                [
                    'attribute' => 'person_type',
                    'filter' => PersonTypeHelper::getList()
                ],
                //'nickname',
                //'birth_date',
                //'sex',
                //'nationality_id',
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

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update}'
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>

<?php $this->endBlock() ?>

<?php $this->beginBlock('tools') ?>
<?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['create'], ['class' => 'btn btn-default']) ?>
<?php $this->endBlock() ?>

<?= $this->render('_layout') ?>