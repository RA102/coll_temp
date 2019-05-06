<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $enlistEntrantForm \frontend\models\forms\EnlistEntrantForm */
/** @var $groups array */

Modal::begin([
    'id'     => 'enlist-admission-application-modal',
    'header' => '<h4 class="modal-title">Зачисление</h4>',
]);

$form = ActiveForm::begin([
    'action' => '/admission-application/enlist',
]);

echo $form->field($enlistEntrantForm, 'admission_application_id')
    ->hiddenInput()
    ->label(false)
    ->error(false);
echo $form->field($enlistEntrantForm, 'group_id')->widget(
    \kartik\select2\Select2::class,
    [
        'data'          => \yii\helpers\ArrayHelper::map($groups, 'id', 'name'),
        'theme'         => 'default',
        'pluginOptions' => [
            'allowClear' => true
        ],
        'options'       => ['prompt' => Yii::t('app', 'Выбрать')],
    ]
)->label(false);

echo Html::submitButton(Yii::t('app', 'Зачислить'), [
    'class' => 'btn btn-success'
]);

ActiveForm::end();

Modal::end();

$js = <<<JS
(function() {
    $('#enlist-admission-application-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var admissionApplicationId = button.data('admission-application-id');
        var modal = $(this);
        console.log(admissionApplicationId);
        modal.find('.modal-body #admission_application_id').val(admissionApplicationId)
    });
})();
JS;

$this->registerJs($js);
?>