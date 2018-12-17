<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use \common\models\person\Person;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\search\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Students');
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1>Студенты (<?=$dataProvider->count?>)</h1>
    <?= Html::a('Добавить', ['create'], ['class' => 'title-action btn btn-primary']) ?>
</div>


<div class="student-index student-block">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="card-header">
        <ul class="nav nav-tabs">
            <li role="presentation" class="<?=$searchModel->isActive() ? 'active' : ''?>">
                <?= Html::a('Текущие студенты', Url::current([
                    Html::getInputName($searchModel, 'status') => Person::STATUS_ACTIVE,
                ])) ?>
            </li>
            <li role="presentation" class="<?=$searchModel->isFired() ? 'active' : ''?>">
                <?= Html::a('Исключенные студенты', Url::current([
                    Html::getInputName($searchModel, 'status') => Person::STATUS_FIRED,
                ])) ?>
            </li>
            <li role="presentation" class="<?=$searchModel->status == Person::STATUS_DELETED ? 'active' : ''?>">
                <?= Html::a('Удаленные студенты', Url::current([
                    Html::getInputName($searchModel, 'status') => Person::STATUS_DELETED,
                ])) ?>
            </li>
        </ul>
    </div>


    <div class="card-body">
        <?= GridView::widget([
            'layout' =>  "{items}\n{pager}",
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //                'id',
                //                'status',
                //                'nickname',
                'firstname',
                'lastname',
                'middlename',
                'birth_date',
                //'sex',
                //'nationality_id',
                'iin',
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

                ['class' => 'yii\grid\ActionColumn', 'template' => '{view}',],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>


<?php $this->beginBlock('tools') ?>
<?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['create'], ['class' => 'btn btn-default']) ?>
<?php $this->endBlock() ?>
