<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ReceptionGroup */
/* @var $examDataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'View');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => ['index', 'commission_id' => $model->commission_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div style="position: relative;">
    <h1 class="pull-left"><?=$this->title?></h1>
    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'pull-right btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger pull-right',
        'style' => 'margin-right: 10px;',
        'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ]) ?>
</div>
<div class="clearfix"></div>

<div class="card">
    <div class="card-body">
        <div class="reception-group-view">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
//                    'id',
                    'caption_current',
                    [
                        'format'    => 'html',
                        'attribute' => 'language',
                        'value'     => function (\common\models\ReceptionGroup $model) {
                            return $model->getLanguage();
                        },
                    ],
                    [
                        'format'    => 'html',
                        'attribute' => 'speciality_id',
                        'value'     => function (\common\models\ReceptionGroup $model) {
                            return $model->speciality->caption_current;
                        },
                    ],
                    [
                        'format'    => 'html',
                        'attribute' => 'education_form',
                        'value'     => function (\common\models\ReceptionGroup $model) {
                            return $model->getEducationForm();
                        },
                    ],
                    'budget_places',
                    'commercial_places',
                    'create_ts',
                ],
            ]) ?>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $examDataProvider,
            'columns' => [
                'date',
                'time',
                [
                    'attribute' => 'institution_discipline_id',
                    'value' => function (\common\models\ReceptionExam $model) {
                        return $model->institutionDiscipline->caption_current;
                    },
                ],
                'commission_id',
            ],
        ]); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <a href="<?= \yii\helpers\Url::to(['/reception-exam-grade/index', 'reception_group_id' => $model->id]) ?>">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa fa-bell fa-3x"></i>
                    <h4><?=Yii::t('app', 'Результаты вступительных экзаменов')?></h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= \yii\helpers\Url::to(['/reception-group/entrants', 'reception_group_id' => $model->id]) ?>">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa fa-user-tie fa-3x"></i>
                    <h4><?=Yii::t('app', 'Entrants')?></h4>
                </div>
            </div>
        </a>
    </div>
</div>