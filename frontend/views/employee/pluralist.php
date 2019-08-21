<?php

use common\models\person\Employee;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use \common\models\person\Person;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\search\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Совместители';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?= $this->title ?> (<?= $dataProvider->totalCount ?>)</h1>
    <?= Html::a('Создать', ['create-pluralist'], ['class' => ' btn btn-primary']) ?>
    <?= Html::a('Выбрать из системы', ['choose-pluralist'], ['class' => ' btn btn-primary']) ?>
    <hr>
</div>


<div class="employee-index student-block">
    <?= Html::beginForm(['process'], 'post'); ?>
    <div class="card-header">
        <ul class="nav nav-tabs">
            <li role="presentation" class="">
                <?= Html::a(Yii::t('app', 'Current employees'), [
                    '/employee?status=' . Person::STATUS_ACTIVE,
                ]) ?>
            </li>
            <li role="presentation" class="active">
                <?= Html::a('Совместители', ['pluralist'], []) ?>
            </li>
            <li role="presentation" class="">
                <?= Html::a('Уволенные сотрудники', [
                    '/employee?status=' . Person::STATUS_FIRED
                ]) ?>
            </li>
            <li role="presentation" class="">
                <?= Html::a('Удаленные сотрудники', [
                    '/employee?status=' . Person::STATUS_DELETED,
                ]) ?>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <?= Html::submitButton(
            'Уволить',
            [
                'class' => 'btn btn-warning',
                'name' => 'action',
                'value' => 'fire',
                'visible' => false
            ]
        ); ?>
        <?= Html::submitButton(
            'Удалить',
            [
                'class' => 'btn btn-danger',
                'name' => 'action',
                'value' => 'delete',
                'visible' => false
            ]
        ); ?>
        <?= GridView::widget([
            'layout' => "{items}\n{pager}",
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'formatter' => [
                'class' => '\yii\i18n\Formatter',
                'dateFormat' => 'dd.MM.yyyy',
                'datetimeFormat' => 'dd.MM.yyyy HH:mm::ss',
            ],
            'columns' => [
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'checkboxOptions' => function ($model) {
                        return ['value' => $model->id];
                    },
                ],
                ['class' => 'yii\grid\SerialColumn'],

                //                'id',
                //                'status',
                //                'nickname',
                'lastname',
                'firstname',
                'middlename',
                'birth_date:date',
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

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{revert} {move} {view} {fire} {delete}',
                    'buttons' => [
                        'fire' => function ($url, Employee $model) {
                            return Html::a('<span class="glyphicon glyphicon-fire"></span>',
                                ['employee/fire', 'id' => $model->id], [
                                    'data-confirm' => Yii::t('app', 'Are you sure?'),
                                    'data-method' => 'post',
                                    'title' => Yii::t('app', 'Fire Employee'),
                                ]);
                        },
                        'revert' => function ($url, Employee $model) {
                            return Html::a('<span class="glyphicon glyphicon-retweet"></span>',
                                ['employee/revert', 'id' => $model->id], [
                                    'data-confirm' => Yii::t('app', 'Are you sure?'),
                                    'data-method' => 'post',
                                    'title' => Yii::t('app', 'Revert'),
                                ]);
                        },
                        'move' => function ($url, Employee $model) {
                            return Html::a('<span class="glyphicon glyphicon-share-alt"></span>',
                                ['employee/move', 'id' => $model->id], [
                                    'data-confirm' => Yii::t('app', 'Are you sure?'),
                                    'data-method' => 'post',
                                    'title' => Yii::t('app', 'Move to student'),
                                ]);
                        }
                    ],
                    'visibleButtons' => [
                        'fire' => function (Employee $model) {
                            /** @see \common\services\person\PersonService::fire() */
                            return !$model->isDeleted() && !$model->isFired();
                        },
                        'delete' => function (Employee $model) {
                            /** @see \common\services\person\PersonService::delete() */
                            return !$model->isDeleted();
                        },
                        'revert' => function (Employee $model) {
                            return $model->isDeleted() || $model->isFired();
                        }
                    ],
                ],
            ],
        ]); ?>
    </div>

    <?= Html::endForm();?>
</div>


<?php $this->beginBlock('tools') ?>
<?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['create'], ['class' => 'btn btn-default']) ?>
<?php $this->endBlock() ?>
