<?php

use common\models\reception\Commission;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\reception\Commission */

$commissionService = new \common\services\reception\CommissionService;
$activeCommission = $commissionService->getActiveInstitutionCommission(\Yii::$app->user->identity->institution);

$this->title = ($model->id == ($activeCommission->id ?? null) ? Yii::t('app', 'Current Commission') : $model->caption_current);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<h1><?= Html::encode($model->caption_current) ?></h1>

<div class="card">
    <div class="card-body">

        <p>
            <?php if ($model->status == Commission::STATUS_ACTIVE): ?>
                <?= Html::a(Yii::t('app', 'Close'), ['close', 'id' => $model->id], [
                    'class' => 'btn btn-warning',
                    'data'  => [
                        'confirm' => 'Are you sure you want to close this commission?',
                        'method'  => 'post',
                    ],
                ]) ?>
            <?php endif; ?>

            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data'  => [
                    'confirm' => 'Are you sure you want to delete this commission?',
                    'method'  => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model'      => $model,
            'attributes' => [
                'caption_current',
                'from_date',
                'to_date',
                'order_number',
                'order_date',
                'exam_start_date',
                'exam_end_date',
                [
                    'attribute' => 'institution_discipline_ids',
                    'value'     => function (\common\models\reception\Commission $model) {
                        return implode(', ',
                            \yii\helpers\ArrayHelper::getColumn($model->institutionDisciplines, 'caption_current'));
                    },
                ],
                [
                    'attribute' => 'status',
                    'value'     => function (\common\models\reception\Commission $model) {
                        return \common\helpers\CommissionHelper::getStatusList()[$model->status];
                    }
                ],
            ],
        ]) ?>

    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <a href="<?= \yii\helpers\Url::to(['/commission-member/index', 'commission_id' => $model->id]) ?>">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa fa-user-tie fa-3x"></i>
                    <h4><?= Yii::t('app', 'Commission members') ?></h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= \yii\helpers\Url::to(['/reception-group/index', 'commission_id' => $model->id]) ?>">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa fa-user-friends fa-3x"></i>
                    <h4><?= Yii::t('app', 'Groups') ?></h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= \yii\helpers\Url::to(['/reception-exam/index', 'commission_id' => $model->id]) ?>">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa fa-calendar-alt fa-3x"></i>
                    <h4><?= Yii::t('app', 'Exams schedule') ?></h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= \yii\helpers\Url::to(['/appeal-commission/view', 'id' => $model->id]) ?>">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa fa-user-check fa-3x"></i>
                    <h4><?= Yii::t('app', 'Appeal Commission') ?></h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= \yii\helpers\Url::to("{$model->id}/report") ?>">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa fa-file-alt fa-3x"></i>
                    <h4><?= Yii::t('app', 'Reports') ?></h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= \yii\helpers\Url::to(["/competition/{$model->id}"]) ?>">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa fa-user-check fa-3x"></i>
                    <h4><?= Yii::t('app', 'Competitions') ?></h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= \yii\helpers\Url::to(['/rating/index', 'commission_id' => $model->id]) ?>">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa fa-bar-chart fa-3x"></i>
                    <h4><?= Yii::t('app', 'Ratings') ?></h4>
                </div>
            </div>
        </a>
    </div>
</div>

