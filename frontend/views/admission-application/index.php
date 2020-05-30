<?php

use common\helpers\ApplicationHelper;
use common\models\reception\AdmissionApplication;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\date\DatePicker;

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
        <?=GridView::widget([
            'layout'       => "{items}\n{pager}",
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'formatter' => [
                'class' => '\yii\i18n\Formatter',
                'dateFormat' => 'dd.MM.yyyy',
                'datetimeFormat' => 'dd.MM.yyyy HH:mm::ss',
            ],            
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'fio',
                    'label' => Yii::t('app', 'Ф.И.О'),
                    'value' => 'person.fullname',
                ],
                [
                    'attribute' => 'application_date',
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'value' => $searchModel->application_date,
                        'attribute' => 'application_date',
                        'type' => 1,
                    ]),
                    'filterOptions' => ['style' => 'width: 120px'],
                    'label' => Yii::t('app', 'Дата подачи'),
                    'value' => 'properties.application_date', 
                    'format' => 'date'
                ],
                [
                    'attribute' => 'iin',
                    'value' => 'person.iin',
                    'label' => Yii::t('app', 'ИИН'),
                    'filterOptions' => ['style' => 'width: 140px'],
                ],
                [
                    'attribute' => 'status',
                    'filter' => false,
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
                    'attribute' => 'online',
                    'filter' => false,
                    'format'    => 'html',
                    'value'     => function (AdmissionApplication $admissionApplication) {
                        $labelText = ApplicationHelper::getAdmissionApplicationOnlineLabels()[$admissionApplication->online];
                        $onlineClass = (function () use ($admissionApplication) {
                            if ($admissionApplication->online === ApplicationHelper::ONLINE_NO) {
                                return 'label label-info';
                            }
                            if ($admissionApplication->online === ApplicationHelper::ONLINE_EGOV) {
                                return 'label label-success';
                            }
                            if ($admissionApplication->online === ApplicationHelper::ONLINE_BILIMAL) {
                                return 'label label-primary';
                            }
                            return 'label label-info';
                        })();

                        return "<span class='{$onlineClass}'>{$labelText}</span>";
                    }
                ],                
                [
                    'class'    => 'yii\grid\ActionColumn',
                    'template' => '{view}  {update}',
                    'visibleButtons' => [
                        'view' => true,
                        'update' => function (AdmissionApplication $admissionApplication) {
                            $res = true;
                            if ($admissionApplication->online != null && $admissionApplication->online > 0){
                                $res = false;
                            }
                            return $res;
                        },
                    ],                    

                ]
            ],
        ]); ?>
    </div>
</div>
