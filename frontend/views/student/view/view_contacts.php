<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Student */

?>

<?php $this->beginBlock('view-content') ?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'label' => 'Домашний телефон',
            'value' => null
        ],
        [
            'label' => 'Мобильный телефон',
            'value' => null
        ],
        [
            'label' => 'Гражданство',
            'value' => null
        ],
        [
            'label' => 'Адрес прописки',
            'value' => null
        ],
        [
            'label' => 'Домашний адрес',
            'value' => null
        ],
        [
            'label' => 'Место рождения',
            'value' => null
        ],
    ],
]) ?>

<?php $this->endBlock() ?>
<?= $this->render('_view_layout', ['model' => $model]) ?>