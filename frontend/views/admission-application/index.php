<?php

use common\helpers\ApplicationHelper;
use common\models\reception\AdmissionApplication;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \frontend\search\AdmissionApplicationSearch */

$this->title = Yii::t('app', 'Заявления');
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?= $this->title ?> (<?= $dataProvider->totalCount ?>)</h1>
    <?= Html::a(Yii::t('app', 'Добавить'), ['create'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="admission-application-index student-block">

    <?php Pjax::begin(); ?>
    <div class="card-header">
        <ul class="nav nav-tabs">
            <li role="presentation"
                class="<?= $searchModel->status == ApplicationHelper::STATUS_CREATED ? 'active' : '' ?>">
                <?= Html::a(Yii::t('app', 'Создано'), Url::current([
                    Html::getInputName($searchModel, 'status') => ApplicationHelper::STATUS_CREATED,
                ])) ?>
            </li>
            <li role="presentation"
                class="<?= $searchModel->status == ApplicationHelper::STATUS_ACCEPTED ? 'active' : '' ?>">
                <?= Html::a(Yii::t('app', 'Зарегистрировано'), Url::current([
                    Html::getInputName($searchModel, 'status') => ApplicationHelper::STATUS_ACCEPTED,
                ])) ?>
            </li>
            <li role="presentation"
                class="<?= $searchModel->status == ApplicationHelper::STATUS_DECLINED ? 'active' : '' ?>">
                <?= Html::a('Отказано', Url::current([
                    Html::getInputName($searchModel, 'status') => ApplicationHelper::STATUS_DECLINED,
                ])) ?>
            </li>
            <li role="presentation"
                class="<?= $searchModel->status == ApplicationHelper::STATUS_ENLISTED ? 'active' : '' ?>">
                <?= Html::a(Yii::t('app', 'Зачислены'), Url::current([
                    Html::getInputName($searchModel, 'status') => ApplicationHelper::STATUS_ENLISTED,
                ])) ?>
            </li>
            <li role="presentation"
                class="<?= $searchModel->status == ApplicationHelper::STATUS_WITHDRAWN ? 'active' : '' ?>">
                <?= Html::a(Yii::t('app', 'Отозвано'), Url::current([
                    Html::getInputName($searchModel, 'status') => ApplicationHelper::STATUS_WITHDRAWN,
                ])) ?>
            </li>
            <li role="presentation"
                class="<?= $searchModel->status == ApplicationHelper::STATUS_DELETED ? 'active' : '' ?>">
                <?= Html::a(Yii::t('app', 'Удалено'), Url::current([
                    Html::getInputName($searchModel, 'status') => ApplicationHelper::STATUS_DELETED,
                ])) ?>
            </li>
        </ul>
    </div>


    <div class="card-body">
        <?= GridView::widget([
            'layout'       => "{items}\n{pager}",
            'dataProvider' => $dataProvider,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => Yii::t('app', 'Ф.И.О'),
                    'value' => 'person.fullname'
                ],
                [
                    'label' => Yii::t('app', 'Дата подачи'),
                    'value' => 'properties.application_date',
                ],
                'person.iin',
                [
                    'attribute' => 'status',
                    'format'    => 'html',
                    'value'     => function (AdmissionApplication $admissionApplication) {
                        $labelText = ApplicationHelper::$list[$admissionApplication->status];
                        $statusClass = (function () use ($admissionApplication) {
                            if ($admissionApplication->status === ApplicationHelper::STATUS_CREATED) {
                                return 'label label-primary';
                            }
                            if ($admissionApplication->status === ApplicationHelper::STATUS_ACCEPTED) {
                                return 'label label-success';
                            }
                            if ($admissionApplication->status === ApplicationHelper::STATUS_DECLINED) {
                                return 'label label-danger';
                            }
                            if ($admissionApplication->status === ApplicationHelper::STATUS_ENLISTED) {
                                return 'label label-success';
                            }
                            if ($admissionApplication->status === ApplicationHelper::STATUS_DELETED) {
                                return 'label label-danger';
                            }
                            return 'label label-primary';
                        })();

                        return "<span class='{$statusClass}'>{$labelText}</span>";
                    }
                ],
                [
                    'class'    => 'yii\grid\ActionColumn',
                    'template' => '{view} {update}',
                ]
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
