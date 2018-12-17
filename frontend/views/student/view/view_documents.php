<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Student */

?>

<?php $this->beginBlock('view-content') ?>

    <legend class="text-semibold center-block">
        <?= 'Удостоверение личности'?>
    </legend>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Номер удостоверения личности',
                'value' => null
            ],
            [
                'label' => 'Дата выдачи',
                'value' => null
            ],
            [
                'label' => 'Действительно до',
                'value' => null
            ],
        ],
    ]) ?>

    <legend class="text-semibold center-block">
        <?= 'Паспорт'?>
    </legend>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Серия',
                'value' => null
            ],
            [
                'label' => 'Номер паспорта',
                'value' => null
            ],
            [
                'label' => 'Дата выдачи',
                'value' => null
            ],
            [
                'label' => 'Действителен до',
                'value' => null
            ],
        ],
    ]) ?>

<?php $this->endBlock() ?>
<?= $this->render('_view_layout', ['model' => $model]) ?>