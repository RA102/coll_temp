<?php

use common\models\person\Person;
use common\models\person\PersonCredential;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'People');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'status',
            'nickname',
            'firstname',
            'lastname',
            [
                'format' => 'html',
                'value' => function (Person $model) {
                    return array_reduce($model->personCredentials, function(PersonCredential $model) {
                        return $model->indentity . '<hr/>';
                    }, '');
                }
            ]
            //'middlename',
            //'birth_date',
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
        ],
    ]); ?>
</div>
