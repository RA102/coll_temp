<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Student */

?>

<?php $this->beginBlock('view-content') ?>

    <?php foreach ($model->relatives as $relative): ?>
    <legend class="text-semibold center-block">
        <?= $relative->getRelationType()?>
    </legend>
    <?= DetailView::widget([
        'model' => $relative,
        'attributes' => [
            [
                'label' => $relative->getAttributeLabel('firstname'),
                'value' => $relative->getFullName(),
            ],
            'birth_date:date',
            'iin',
            'home_phone',
            'mobile_phone',
            'email:email',
        ],
    ]) ?>
    <?php endforeach;?>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['student/update-relatives', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

<?php $this->endBlock() ?>
<?= $this->render('_view_layout', ['model' => $model]) ?>