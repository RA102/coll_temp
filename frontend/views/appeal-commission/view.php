<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealCommission */
/* @var $commission_id int */

$this->title = 'Аппеляционная комиссия';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Appeal Commissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php if($model) {?>
<p>
    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
</p>
<?php }?>

<div class="card">
    <div class="card-body">
        <div class="appeal-commission-view">

            <?php if ($model) {?>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'caption',
                    'commission_id',
                    'from_date',
                    'to_date',
                    'order_number',
                    'order_date',
                    'create_ts',
                    'update_ts',
                    'delete_ts',
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