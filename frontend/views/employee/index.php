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

$this->title = Yii::t('app', 'Employees');
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?= $this->title ?> (<?= $dataProvider->totalCount ?>)</h1>
    <?= Html::a('Добавить', ['create'], ['class' => 'title-action btn btn-primary']) ?>
</div>


<div class="employee-index student-block">

    <?= Html::beginForm(['process'], 'post'); ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="card-header">
        <ul class="nav nav-tabs">
            <li role="presentation" class="<?= $searchModel->isActive() ? 'active' : '' ?>">
                <?= Html::a(Yii::t('app', 'Current employees'), Url::current([
                    Html::getInputName($searchModel, 'status') => Person::STATUS_ACTIVE,
                ])) ?>
            </li>
            <li role="presentation" class="<?= $searchModel->isFired() ? 'active' : '' ?>">
                <?= Html::a('Уволенные сотрудники', Url::current([
                    Html::getInputName($searchModel, 'status') => Person::STATUS_FIRED,
                ])) ?>
            </li>
            <li role="presentation" class="<?= $searchModel->status == Person::STATUS_DELETED ? 'active' : '' ?>">
                <?= Html::a('Удаленные сотрудники', Url::current([
                    Html::getInputName($searchModel, 'status') => Person::STATUS_DELETED,
                ])) ?>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <?php if (intval($searchModel->status) !== Employee::STATUS_ACTIVE): ?>
            <?= Html::submitButton(
                'Восстановить',
                [
                    'class' => 'btn btn-default',
                    'name' => 'action',
                    'value' => 'revert',
                    'visible' => false
                ]
            ); ?>
        <?php endif; ?>
        <?= Html::submitButton(
            'Переместить',
            [
                'class' => 'btn btn-primary',
                'name' => 'action',
                'value' => 'move',
                'visible' => false
            ]
        ); ?>
        <?php if (intval($searchModel->status) === Employee::STATUS_ACTIVE): ?>
        <?= Html::submitButton(
            'Уволить',
            [
                'class' => 'btn btn-warning',
                'name' => 'action',
                'value' => 'fire',
                'visible' => false
            ]
        ); ?>
        <?php endif; ?>
        <?php if (intval($searchModel->status) !== Employee::STATUS_DELETED): ?>
        <?= Html::submitButton(
            'Удалить',
            [
                'class' => 'btn btn-danger',
                'name' => 'action',
                'value' => 'delete',
                'visible' => false
            ]
        ); ?>
        <?php endif; ?>
        <?= GridView::widget([
            'layout' => "{items}\n{pager}",
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
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
