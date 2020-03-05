<?php

use app\models\handbook\PersonSocialStatus;
use common\helpers\ApplicationHelper;
use common\helpers\EducationHelper;
use common\helpers\PersonHelper;
use common\helpers\PersonSocialStatusHelper;
use common\models\Nationality;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $admissionApplication \common\models\reception\AdmissionApplication|null */
/* @var $admissionApplicationForm \frontend\models\forms\AdmissionApplicationForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $specialities common\models\handbook\Speciality[] */

$countriesData = \yii\helpers\ArrayHelper::map(\common\models\Country::find()->all(), 'id', 'caption_current');
$socialStatusesData = \yii\helpers\ArrayHelper::map(
    array_filter(PersonSocialStatus::find()->all(), function (PersonSocialStatus $personSocialStatus) {
        return in_array(PersonSocialStatusHelper::PERSON_SOCIAL_FACILITIES, $personSocialStatus->type->getValue());
    }),
    'id',
    'caption_current'
);
$blockPersonalDataEditing = isset($admissionApplication) ?
    $admissionApplication->status === ApplicationHelper::STATUS_ACCEPTED
    : false;
?>

<?php $form = ActiveForm::begin([
    'id'          => 'admission-application-form',
    'layout'      => 'horizontal',
    'fieldConfig' => [
        'options'              => ['class' => 'form-group', 'style' => 'margin-right: 0; margin-left: 0;'],
        'horizontalCssClasses' => [
            'label' => 'col-sm-2 text-center',
        ]
    ]
]); ?>

    <div class="card">
        <fieldset>
            <legend style="padding: 8px;">Персональные данные</legend>
            <?= $form->field($admissionApplicationForm, 'iin')->textInput([
                'maxlength' => 12,
                'disabled'  => $blockPersonalDataEditing
            ]) ?>
            <?= $form->field($admissionApplicationForm, 'lastname')->textInput([
                'maxlength' => 100,
                'disabled'  => $blockPersonalDataEditing
            ]) ?>
            <?= $form->field($admissionApplicationForm, 'firstname')->textInput([
                'maxlength' => 100,
                'disabled'  => $blockPersonalDataEditing
            ]) ?>

            <?= $form->field($admissionApplicationForm, 'middlename')->textInput([
                'maxlength' => 100,
                'disabled'  => $blockPersonalDataEditing
            ]) ?>
            <?= $form->field($admissionApplicationForm, 'citizenship_location')->widget(Select2::classname(), [
                'data'          => $countriesData,
                'options'       => ['placeholder' => Yii::t('app', 'Введите поисковый запрос')],
                'theme'         => 'default',
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'disabled'      => $blockPersonalDataEditing
            ]); ?>
            <?= $form->field($admissionApplicationForm, 'sex')->dropDownList(PersonHelper::getSexList(), [
                'disabled' => $blockPersonalDataEditing
            ]) ?>
            <?= $form->field($admissionApplicationForm, 'birth_date')->widget(DatePicker::class, [
                'language'      => 'ru',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format'    => 'dd-mm-yyyy'
                ],
                'disabled'      => $blockPersonalDataEditing
            ]); ?>
            <?= $form->field($admissionApplicationForm, 'application_date')->widget(DatePicker::class, [
                'language'      => 'ru',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format'    => 'dd-mm-yyyy'
                ]
            ]); ?>
            <?= $form->field($admissionApplicationForm, 'nationality_id')->widget(Select2::classname(), [
                'data'          => \yii\helpers\ArrayHelper::map(Nationality::find()->all(), 'id', 'name'),
                'options'       => [
                    'disabled'    => $blockPersonalDataEditing,
                    'placeholder' => Yii::t('app', 'Введите поисковый запрос')
                ],
                'theme'         => 'default',
                'pluginOptions' => ['allowClear' => true],
                'disabled'      => $blockPersonalDataEditing
            ]); ?>
            <?= $form->field($admissionApplicationForm, 'is_repatriate')->checkbox([], false) ?>
            <?= $form->field($admissionApplicationForm, 'arrival_location',
                ['options' => ['class' => "form-group" . ($admissionApplicationForm->is_repatriate ? '' : ' hidden')]])->widget(Select2::classname(),
                [
                    'data'          => $countriesData,
                    'options'       => [
                        'disabled'    => $blockPersonalDataEditing,
                        'placeholder' => Yii::t('app', 'Введите поисковый запрос')
                    ],
                    'theme'         => 'default',
                    'pluginOptions' => ['allowClear' => true],
                ]); ?>
        </fieldset>

        <fieldset>
            <legend style="padding: 8px;">Контактные данные</legend>
            <?= $form->field($admissionApplicationForm, 'email')->textInput([
                'maxlength' => true,
            ]) ?>
            <?= $form->field($admissionApplicationForm, 'contact_phone_home')->textInput(['maxlength' => true]) ?>
            <?= $form->field($admissionApplicationForm, 'contact_phone_mobile')->textInput(['maxlength' => true]) ?>
        </fieldset>

        <fieldset>
            <legend style="padding: 8px;">Сведения о поступлении</legend>
            <?= $form->field($admissionApplicationForm, 'filing_form')->dropDownList([
                0 => Yii::t('app', 'Обычным способом'),
                1 => Yii::t('app', 'Онлайн')
            ], ['disabled' => $blockPersonalDataEditing]) ?>
            <?= $form->field($admissionApplicationForm, 'education_form')->dropDownList(
                EducationHelper::getEducationFormTypes(),
                ['prompt' => Yii::t('app', 'Выбрать'), 'disabled' => $blockPersonalDataEditing]
            ) ?>
            <?= $form->field($admissionApplicationForm, 'speciality_id')->widget(Select2::class, [
                'data'          => \yii\helpers\ArrayHelper::map(
                    $specialities,
                    'id',
                    function (\common\models\handbook\Speciality $model) {
                        return $model->getCaptionWithCode();
                    }
                ),
                'options'       => [
                    'placeholder' => Yii::t('app', 'Введите поисковый запрос'),
                    'disabled'    => $blockPersonalDataEditing
                ],
                'theme'         => 'default',
                'pluginOptions' => ['allowClear' => true],
            ]) ?>
            <?= $form->field($admissionApplicationForm, 'language')->dropDownList(
                \common\helpers\LanguageHelper::getLanguageList(),
                ['prompt' => Yii::t('app', 'Выбрать'), 'disabled' => $blockPersonalDataEditing]
            ) ?>
        </fieldset>

        <?= $form->field($admissionApplicationForm,
            'needs_dormitory')->checkbox(['disabled' => $blockPersonalDataEditing], false) ?>
        <?= $form->field($admissionApplicationForm, 'reason_for_dormitory',
            ['options' => ['class' => "form-group" . ($admissionApplicationForm->needs_dormitory ? '' : ' hidden')]])->textInput(['disabled' => $blockPersonalDataEditing]) ?>

        <?= $form->field($admissionApplicationForm, 'education_pay_form')->dropDownList(
            EducationHelper::getPaymentFormTypes(),
            ['prompt' => Yii::t('app', 'Выбрать'), 'disabled' => $blockPersonalDataEditing]
        ) ?>
        <?= $form->field($admissionApplicationForm, 'contract_number',
            [
                'options' => [
                    'class' => "form-group" .
                        ($admissionApplicationForm->education_pay_form == EducationHelper::EDUCATION_PAY_FORM_CONTRACT
                            ? ''
                            : ' hidden')
                ]
            ])->textInput(['disabled' => $blockPersonalDataEditing]); ?>
        <?= $form->field($admissionApplicationForm, 'contract_date', [
            'options' => [
                'class' => "form-group" .
                    ($admissionApplicationForm->education_pay_form == EducationHelper::EDUCATION_PAY_FORM_CONTRACT
                        ? ''
                        : ' hidden')
            ]
        ])->widget(DatePicker::class, [
            'language'      => 'ru',
            'pluginOptions' => [
                'autoclose' => true,
                'format'    => 'yyyy-mm-dd'
            ],
            'disabled'      => $blockPersonalDataEditing
        ]); ?>
        <?= $form->field($admissionApplicationForm, 'contract_sum',
            [
                'options' => [
                    'class' => "form-group" .
                        ($admissionApplicationForm->education_pay_form == EducationHelper::EDUCATION_PAY_FORM_CONTRACT
                            ? ''
                            : ' hidden')
                ]
            ])->textInput(['disabled' => $blockPersonalDataEditing]); ?>
        <?= $form->field($admissionApplicationForm, 'contract_duration',
            [
                'options' => [
                    'class' => "form-group" .
                        ($admissionApplicationForm->education_pay_form == EducationHelper::EDUCATION_PAY_FORM_CONTRACT
                            ? ''
                            : ' hidden')
                ]
            ])->textInput(['disabled' => $blockPersonalDataEditing, 'placeholder' => Yii::t('app', 'Month or year')]); ?>
        <?= $form->field($admissionApplicationForm, 'based_classes')->dropDownList(
            \common\helpers\ApplicationHelper::getBasedClassesArray(),
            ['prompt' => Yii::t('app', 'Выбрать'), 'disabled' => $blockPersonalDataEditing]
        ) ?>


        <fieldset>
            <legend style="padding: 8px;">Льготы</legend>
            <?= $form->field($admissionApplicationForm, 'social_statuses', [
                'horizontalCssClasses' => [
                    'offset'  => '',
                    'wrapper' => 'col-sm-12',
                ]
            ])->widget(\unclead\multipleinput\MultipleInput::class,
                [
                    'min'     => 0,
                    'max'     => 6,
                    'columns' => [
                        [
                            'name'          => 'name',
                            'type'          => \unclead\multipleinput\MultipleInputColumn::TYPE_DROPDOWN,
                            'title'         => Yii::t('app', 'Наименование'),
                            'items'         => $socialStatusesData,
                            'enableError'   => true,
                            'headerOptions' => ['width' => '40%'],
                            'options'       => ['prompt' => Yii::t('app', 'Выбрать')]
                        ],
                        [
                            'name'  => 'comment',
                            'title' => Yii::t('app', 'Комментарий'),
                        ],
                        [
                            'name'  => 'document_number',
                            'title' => Yii::t('app', 'Номер документа')
                        ]
                    ]
                ])->label(false);
            ?>
        </fieldset>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

<?php
$listOfDependencies = json_encode([
    [
        'mainId'                => Html::getInputId($admissionApplicationForm, 'is_repatriate'),
        'dependantFieldClasses' => ['field-' . Html::getInputId($admissionApplicationForm, 'arrival_location')],
    ],
    [
        'mainId'                => Html::getInputId($admissionApplicationForm, 'needs_dormitory'),
        'dependantFieldClasses' => ['field-' . Html::getInputId($admissionApplicationForm, 'reason_for_dormitory')],
    ],
    [
        'mainId'                => Html::getInputId($admissionApplicationForm, 'education_pay_form'),
        'dependantFieldClasses' => [
            'field-' . Html::getInputId($admissionApplicationForm, 'contract_number'),
            'field-' . Html::getInputId($admissionApplicationForm, 'contract_date'),
            'field-' . Html::getInputId($admissionApplicationForm, 'contract_sum'),
            'field-' . Html::getInputId($admissionApplicationForm, 'contract_duration'),
        ],
        'desiredValue'          => EducationHelper::EDUCATION_PAY_FORM_CONTRACT
    ]
]);

$js = <<<JS
(function() {
    {$listOfDependencies}.forEach(function (relation) {
        $("#" + relation.mainId).on('change', function (e) {
            var shouldDisplay = relation.desiredValue ? relation.desiredValue == e.target.value : $(this).is(":checked")
            if(shouldDisplay) {
                relation.dependantFieldClasses.forEach(function (fieldClass) {
                    $("." + fieldClass).removeClass("hidden"); 
                });
            } else {
                relation.dependantFieldClasses.forEach(function (fieldClass) {
                    $("." + fieldClass).addClass("hidden"); 
                });
            }
        })
    });
})();
    $( document ).ready(function() {
        $(".field-admissionapplicationform-iin").append("<button id='find_by_iin' class='btn btn-success'>Поиск</button>");
            $("#find_by_iin").on("click",function() {
        var iin=$("#admissionapplicationform-iin").val();
        $.ajax({
                type: "GET",
                url: "/student/get-student-info",
                data: {"iin":iin},
                success: function(data){
                    if(data!=null){
                    $("#admissionapplicationform-lastname").val(data.lastname);
                    $("#admissionapplicationform-firstname").val(data.firstname);
                    $("#admissionapplicationform-middlename").val(data.middlename);
                    $("#admissionapplicationform-citizenship_location").val(data.citizenship_location);
                    $("#admissionapplicationform-citizenship_location").val(data.citizenship_location);
                    $("#admissionapplicationform-birth_date").val(data.birth_date);
                    $("#admissionapplicationform-nationality_id").val(data.nationality_id);
                    $("#admissionapplicationform-sex").val(data.sex);
                    $("#admissionapplicationform-is_repatriate").val(data.is_repatriate);
                    }
                    else{
                        alert("Человек с данным ИИН отсутствует в базе");
                    }

                },
            });
    });
    });
    


JS;

$this->registerJs($js);


?>
<script>


</script>

