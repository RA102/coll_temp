<?php

use common\helpers\ApplicationHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $admissionApplication common\models\reception\AdmissionApplication */
/* @var $changeStatusForm \frontend\models\reception\admission_application\ChangeStatusForm */
/* @var $receptionGroups \common\models\ReceptionGroup[] */

$this->title = Yii::t('app', 'Изменить статус');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Заявления'), 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => $admissionApplication->id,
    'url'   => ['view', 'id' => $admissionApplication->id]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $this->beginBlock('content') ?>
<div class="admission-application-change-status">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($changeStatusForm, 'status')->widget(\kartik\select2\Select2::class, [
        'data'    => array_filter(
            ApplicationHelper::getAdmissionApplicationStatusLabels(),
            function (int $status) use ($admissionApplication) {
                if (\Yii::$app->user->identity->isSuperadmin()) {
                    if ($admissionApplication->status == 0){
                        return $status >= $admissionApplication->status;
                    } else {
                        return $status = $admissionApplication->status;
                    }
                } else {
                    return $status >= $admissionApplication->status;                    
                }
            },
            ARRAY_FILTER_USE_KEY
        ),
        'options' => [
            'placeholder' => \Yii::t('app', 'Выбрать')
        ],
        'theme'   => 'default'
    ]) ?>

    <?= $form->field($changeStatusForm, 'reception_group_id', [
        'options' => ['class' => 'form-group' . ($changeStatusForm->status == ApplicationHelper::STATUS_ACCEPTED ? '' : ' hidden')]
    ])->widget(\kartik\select2\Select2::class, [
        /** @see Group::$caption_current */
        'data'          => \yii\helpers\ArrayHelper::map($receptionGroups, 'id', 'caption_current'),
        'options'       => ['placeholder' => Yii::t('app', 'Введите поисковый запрос')],
        'theme'         => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($changeStatusForm, 'reason', [
        'options' => [
            'class' => 'form-group' . (in_array($changeStatusForm->status,
                    [ApplicationHelper::STATUS_WITHDRAWN, ApplicationHelper::STATUS_DECLINED]) ? '' : ' hidden')
        ]
    ]); ?>

    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>

    <?php $form = ActiveForm::end(); ?>
</div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>

<?php
$statusElementId = Html::getInputId($changeStatusForm, 'status');
$receptionGroupIdElementId = Html::getInputId($changeStatusForm, 'reception_group_id');
$reasonElementId = Html::getInputId($changeStatusForm, 'reason');
$dependantElements = json_encode([$receptionGroupIdElementId, $reasonElementId]);
$conditions = json_encode([
    ApplicationHelper::STATUS_ACCEPTED  => $receptionGroupIdElementId,
    ApplicationHelper::STATUS_WITHDRAWN => $reasonElementId,
    ApplicationHelper::STATUS_DECLINED  => $reasonElementId
]);
$js = <<<JS
(function() {
    $('#{$statusElementId}').change(function (e) {
        var chosenElementId = {$conditions}[e.target.value];
        {$dependantElements}.forEach(function(dependantElementId) {
          if (dependantElementId == chosenElementId) {
            $('#' + dependantElementId).closest('.form-group').removeClass('hidden');
          } else {
            $('#' + dependantElementId).val(null).change();
            $('#' + dependantElementId).closest('.form-group').addClass('hidden');
          }
        });
    });
})();
JS;
$this->registerJs($js);
?>
