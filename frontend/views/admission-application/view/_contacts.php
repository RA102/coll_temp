<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AdmissionApplication */
?>

<?= DetailView::widget([
    'model'      => $model,
    'attributes' => [
        [
            'label' => Yii::t('app', 'Email'),
            'value' => $model->properties['email'],
        ],
        [
            'label' => Yii::t('app', 'Home Phone'),
            'value' => $model->properties['contact_phone_home']
        ],
        [
            'label' => Yii::t('app', 'Mobile Phone'),
            'value' => $model->properties['contact_phone_mobile'],
        ],
    ],
]) ?>

<?= $this->render('_actions', compact('model'));