<?php

use common\helpers\EducationHelper;
use frontend\models\forms\EntranceExamsReportForm;
use kartik\select2\Select2;
use yii\helpers\Html;

/* @var $commission \common\models\reception\Commission */
/* @var $entranceExamsReportForm EntranceExamsReportForm */
/* @var $specialities common\models\handbook\Speciality[] */

$this->title = Yii::t('app', 'Forms');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commissions'), 'url' => ['/commission/index']];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Commission'),
    'url'   => ['/commission/view', 'id' => $commission->id]
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Reports'),
    'url'   => ['/report/index', 'commission_id' => $commission->id]
];
$this->params['breadcrumbs'][] = $this->title;

$formsForBasedClasses = [EntranceExamsReportForm::FORM_7, EntranceExamsReportForm::FORM_8];
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card">
        <div class="card-body">
            <?php $form = \yii\widgets\ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($entranceExamsReportForm, 'education_form')->dropDownList(
                        EducationHelper::getEducationFormTypes(),
                        ['prompt' => Yii::t('app', 'Выбрать')]
                    ) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($entranceExamsReportForm, 'education_pay_form')->dropDownList(
                        EducationHelper::getPaymentFormTypes(),
                        ['prompt' => Yii::t('app', 'Выбрать')]
                    ) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($entranceExamsReportForm, 'language')->dropDownList(
                        \common\helpers\LanguageHelper::getLanguageList(),
                        ['prompt' => Yii::t('app', 'Выбрать')]
                    ) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($entranceExamsReportForm, 'speciality_id')->widget(Select2::class, [
                        'data'          => \yii\helpers\ArrayHelper::map(
                            $specialities,
                            'id',
                            'caption_current'
                        ),
                        'options'       => [
                            'placeholder' => Yii::t('app', 'Введите поисковый запрос'),
                        ],
                        'theme'         => 'default',
                        'pluginOptions' => ['allowClear' => true],
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($entranceExamsReportForm, 'type')->dropDownList(
                        \frontend\models\forms\EntranceExamsReportForm::getListOfForms(),
                        ['prompt' => Yii::t('app', 'Выбрать')]
                    ) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($entranceExamsReportForm, 'based_classes', [
                        'options' => [
                            'class' => "form-group" . (in_array($entranceExamsReportForm->type,
                                    $formsForBasedClasses) ? '' : ' hidden')
                        ]
                    ])->dropDownList(
                        \common\helpers\ApplicationHelper::getBasedClassesArray(),
                        ['prompt' => Yii::t('app', 'Выбрать')]
                    ) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <?= Html::submitButton("Сформировать", ['class' => 'btn btn-primary']); ?>
                </div>
            </div>
            <?php \yii\widgets\ActiveForm::end() ?>
        </div>
    </div>

<?php
$fieldId = Html::getInputId($entranceExamsReportForm, 'type');
$dependantFieldClass = 'field-' . Html::getInputId($entranceExamsReportForm, 'based_classes');
$formsForBasedClassesJson = json_encode($formsForBasedClasses);
$js = <<<JS
(function() {
    $("#{$fieldId}").on('change', function (e) {
        console.log(parseInt(e.target.value));
        if ({$formsForBasedClassesJson}.indexOf(parseInt(e.target.value)) !== -1) {
            $(".{$dependantFieldClass}").removeClass('hidden');
            $(".{$dependantFieldClass} select").val(null);
        } else {
            $(".{$dependantFieldClass}").addClass('hidden');
        }
    }); 
})();
JS;
$this->registerJs($js);
?>