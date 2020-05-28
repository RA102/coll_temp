<?php

use common\models\organization\InstitutionSpecialityInfo;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\handbook\Speciality;

use yii\bootstrap\Modal;

?>

<div class="rup-qualifications-form">

    <?php $form = ActiveForm::begin(); 
            $code = substr($parent_code,0,4) . '%';
            $sp = Speciality::find()->select(["code", "caption"])->where(['type' => '3'])->andWhere(['like', 'code', $code, false])->all();
    ?>

    <?= $form->field($model, 'qualification_code')->dropDownList(ArrayHelper::map($sp, 'code', 'CaptionWithCode'))->label('Квалификация')  ?>

    <?= $form->field($model, 'time_years')->textInput(['type'=>'number', 'min'=>'0', 'max'=>'5'])->label('Количество лет') ?>

    <?= $form->field($model, 'time_months')->textInput(['type'=>'number', 'min'=>'0', 'max'=>'11'])->label('Количество месяцев') ?>

    <?= $form->field($model, 'rup_id')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary','id'=>'submitQualification']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

