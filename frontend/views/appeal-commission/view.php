<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealCommission */
/* @var $commission_id int */

$this->title = 'Аппеляционная комиссия';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commissions'), 'url' => ['/commission']];
if ($model) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commission') . ' - ' . $model->commission->caption_current, 'url' => ['/commission/view', 'id' => $model->commission_id]];
}
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php if($model) {?>
    <div style="position: relative;">
        <h1><?=$this->title?></h1>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->commission_id], ['class' => 'title-action btn btn-primary']) ?>
    </div>
<?php }?>

<div class="card">
    <div class="card-body">
        <div class="appeal-commission-view">

            <?php if ($model) {?>
            <?= DetailView::widget([
                'model' => $model,
                'formatter' => [
                    'class' => '\yii\i18n\Formatter',
                    'dateFormat' => 'dd.MM.yyyy',
                    'datetimeFormat' => 'dd.MM.yyyy HH:mm::ss',
                ],
                'attributes' => [
                    'caption_current',
                    'from_date:date',
                    'to_date:date',
//                    'order_number',
//                    'order_date',
                ],
            ]) ?>
            <?php } else { ?>
                <div style="position: relative;">
                    <div>У вас еще не создана апелляционная комиссия. Создать?</div>
                    <?= Html::a('Добавить', ['create', 'id' => $commission_id], ['class' => 'pull-right btn btn-primary']) ?>
                </div>
            <?php }?>

        </div>
    </div>
</div>

<?php if ($model) {?>
<div class="row">
    <div class="col-md-4">
        <a href="<?= \yii\helpers\Url::to(['/appeal-commission-member/index', 'commission_id' => $model->id]) ?>">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa fa-list-ul fa-3x"></i>
                    <h4><?=Yii::t('app', 'Commission members')?></h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="<?= \yii\helpers\Url::to(['/appeal-application/index', 'commission_id' => $model->id]) ?>">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa fa-user-tie fa-3x"></i>
                    <h4><?=Yii::t('app', 'Applications')?></h4>
                </div>
            </div>
        </a>
    </div>
</div>
<?php }?>