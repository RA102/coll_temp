<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Employee */
/* @var $form frontend\models\forms\PersonContactsForm */

?>

<?php $this->beginBlock('view-content') ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'caption_current',
            'from_date',
            'to_date',
            //'order_number',
            //'order_date',
            [
                'attribute' => 'status',
                'value' => function (\common\models\reception\Commission $model) {
                    return \common\helpers\CommissionHelper::getStatusList()[$model->status];
                }
            ],
            'create_ts',
            //'update_ts',
            //'delete_ts',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>

<?php $this->endBlock() ?>
<?= $this->render('_view_layout', ['model' => $model]) ?>