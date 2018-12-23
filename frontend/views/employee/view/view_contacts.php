<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Employee */
/* @var $form frontend\models\forms\PersonContactsForm */

?>

<?php $this->beginBlock('view-content') ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => $form->getAttributeLabel('contact_phone_home'),
                'value' => $form->contact_phone_home,
            ],
            [
                'label' => $form->getAttributeLabel('contact_phone_mobile'),
                'value' => $form->contact_phone_mobile,
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

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update-contacts', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

<?php $this->endBlock() ?>
<?= $this->render('_view_layout', ['model' => $model]) ?>