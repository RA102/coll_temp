<?php

use common\helpers\PersonHelper;
use common\models\Nationality;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\models\forms\StudentGeneralForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'iin')->textInput(['maxlength' => 12]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->dropDownList(PersonHelper::getSexList()) ?>

    <?= $form->field($model, 'birth_date')->widget(DatePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd-mm-yyyy'
        ]
    ]); ?>

    <?= $form->field($model, 'birth_place')->widget(AutoComplete::class, [
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'source' => Url::to(['student/ajax-address']),
            'minLength' => '5',
        ],
    ]); ?>

    <?= $form->field($model, 'nationality_id')
        ->dropDownList(ArrayHelper::map(Nationality::find()->orderBy('name')->all(), 'id', 'name')); ?>

    

    <?= $form->field($model, 'language')->dropDownList(\common\helpers\LanguageHelper::getLanguageList()) ?>

    <?= $form->field($model, 'indentity')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS
(function() {
    
})();
    $( document ).ready(function() {
        $(".field-studentgeneralform-iin").append("<button id='find_by_iin' class='btn btn-success'>Поиск</button>");
            $("#find_by_iin").on("click",function() {
        var iin=$("#studentgeneralform-iin").val();
        $.ajax({
                type: "GET",
                url: "/student/get-student-info",
                data: {"iin":iin},
                success: function(data){
                    if(data!=null){
                        var bdate = new Date(data.birth_date);
                        var day = bdate.getDate(),
                            month = bdate.getMonth() + 1,
                            year = bdate.getFullYear(),
                            month = (month < 10 ? "0" : "") + month;
                            day = (day < 10 ? "0" : "") + day;
                        var bdatestr = ''+day+'-'+month+'-'+year;

                    $("#studentgeneralform-lastname").val(data.lastname);
                    $("#studentgeneralform-firstname").val(data.firstname);
                    $("#studentgeneralform-middlename").val(data.middlename);
                    //$("#studentgeneralform-citizenship_location").data().select2.val('1');
                    //$("#studentgeneralform-citizenship_location").find("option")[1].selected = true;
                    //$("#studentgeneralform-citizenship_location").option[1].selected = true; // = 1; //val(1); //data.citizenship_location);
                    //$("#studentgeneralform-citizenship_location").val(data.citizenship_location);
                    //$("#studentgeneralform-birth_date").val(data.birth_date);
                    $("#studentgeneralform-birth_date").val(bdatestr);
                    //$("#studentgeneralform-nationality_id").data().select2.val(''+data.nationality_id);
                    $("#studentgeneralform-nationality_id").val(''+data.nationality_id);
                    $("#studentgeneralform-sex").val(data.sex);
                    //$("#studentgeneralform-is_repatriate").val(data.is_repatriate);
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
  

