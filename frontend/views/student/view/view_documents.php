<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Student */
/* @var $form frontend\models\forms\PersonDocumentsForm */

?>

<?php $this->beginBlock('view-content') ?>

    <legend class="text-semibold center-block">
        <?= 'Удостоверение личности'?>
    </legend>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => $form->getAttributeLabel('identity_card_number'),
                'value' => $form->identity_card_number,
            ],
            [
                'label' => $form->getAttributeLabel('identity_card_issued_date'),
                'value' => $form->identity_card_issued_date,
            ],
            [
                'label' => $form->getAttributeLabel('identity_card_valid_date'),
                'value' => $form->identity_card_valid_date,
            ],
            [
                'label' => $form->getAttributeLabel('identity_card_issued'),
                'value' => $form->identity_card_issued,
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
                'label' => $form->getAttributeLabel('passport_series'),
                'value' => $form->passport_series,
            ],
            [
                'label' => $form->getAttributeLabel('passport_number'),
                'value' => $form->passport_number,
            ],
            [
                'label' => $form->getAttributeLabel('passport_issued_date'),
                'value' => $form->passport_issued_date,
            ],
            [
                'label' => $form->getAttributeLabel('passport_valid_date'),
                'value' => $form->passport_valid_date,
            ],
            [
                'label' => $form->getAttributeLabel('passport_issued'),
                'value' => $form->passport_issued,
            ],
        ],
    ]) ?>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update-documents', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

<?php $this->endBlock() ?>
<?= $this->render('_view_layout', ['model' => $model]) ?>