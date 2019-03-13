<?php

use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\person\Employee */

?>

<?php $this->beginBlock('view-content') ?>

<?= GridView::widget([
    'layout'       => "{items}\n{pager}",
    'dataProvider' => new \yii\data\ArrayDataProvider([
        'key'       => 'id',
        'allModels' => $model->personCredentials
    ]),
    'showHeader'   => false,
    'columns'      => [
        'indentity'
    ],
]); ?>

<?php
$personCredentialForm = new \frontend\models\forms\PersonCredentialForm();
Modal::begin([
    'header'       => '<span class="modal-title">Добавить авторизационную запись</span>',
    'toggleButton' => [
        'label' => Yii::t('app', 'Create'),
        'class' => 'btn btn-primary'
    ]
]);
$form = ActiveForm::begin(['action' => '/credential/create']);
echo $form->field($personCredentialForm, 'person_id')->hiddenInput(['value' => $model->id])->label(false)->error(false);
echo $form->field($personCredentialForm, 'indentity')->label(false);
echo Html::beginTag('div', ['class' => 'text-right']);
echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']);
echo Html::endTag('div');
ActiveForm::end();
Modal::end();
?>

<?php $this->endBlock() ?>

<?= $this->render('_view_layout', ['model' => $model]) ?>
