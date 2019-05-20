<?php
/* @var $this \yii\web\View */
/* @var $form \frontend\models\forms\EntranceExamOrderForm */
/* @var $institution \common\models\organization\Institution */
/* @var $protocol \common\models\reception\AdmissionProtocol */
/* @var $sortedApplications [] */
?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<body>
<article class="wrapper">
    <div class="units-row">
        <div class="unit-100 ta-right bold">
            <h3><b>«Приказ о допуске</b></h3>
            <h3><b>к вступительным экзаменам»</b></h3>
            <h4><?=$institution->name?></h4>
        </div>
    </div>
    <div class="units-row">
        <div class="unit-50 uppercase">
            <div class="ta-center">
                БҰЙРЫҚ
            </div>
            <div>
                Дата <span class="line-bottom"><?=$form->date?></span>
            </div>
            <div>
                № <span class="line-bottom"><?=$form->number?></span>
            </div>
        </div>
        <div class="unit-50 uppercase ta-center">
            ПРИКАЗ
        </div>
    </div>

    <div class="units-row">
        <p>Решением Приемной комисси и на основании протокола № <span class="line-bottom"><?=$protocol->number?></span> от «<?=$protocol->completion_date?>» . <b>ПРИКАЗЫВАЮ</b> допустить к вступительным экзаменам следующих абитуриентов: </p>
    </div>

    <?php $number = 1;?>
    <?php foreach($sortedApplications as $data):?>
    <div class="units-row">
        <div class="unit-100">
            <span class="line-bottom"><?=$data['education_form'] ?? '__________'?></span> <i>(форма обучения)</i>, <span class="line-bottom"><?=$data['education_pay_form'] ?? '__________'?></span> (основа обучения), <span class="line-bottom"><?=$data['based_classes'] ?? '__________'?></span> (база образования), <span class="line-bottom"><?=$data['language'] ?? '__________'?></span> (язык обучения).
        </div>
        <div class="unit-100">
            По специальности: <span class="line-bottom"><?=$data['speciality']->parent->getCaptionWithCode() ?? '__________'?>)</span> <i>(код и название специальности)</i>
        </div>
        <div class="unit-100">
            Квалификации: <span class="line-bottom"><?=$data['speciality']->getCaptionWithCode() ?? '__________'?>))</span> <i>(код и название квалификации)</i>
        </div>
    </div>
    <div class="margin-20">
        <div class="units-row">
            <?php foreach($data['applications'] as $application):?>
            <div class="unit-100">
                <?="{$number} {$application}"?>
                <?php $number++?>
            </div>
            <?php endforeach;?>
        </div>
    </div>
    <?php endforeach;?>

    <div class="units-row">
<!--        <div class="unit-100 ta-right">-->
<!--            {{ order_for_entrance.director.lastname }} {{ order_for_entrance.director.firstname }} {{ order_for_entrance.director.middlename }}-->
<!--        </div>-->
        <div class="unit-100 ta-right">
            Подпись _______________
        </div>
    </div>
</article>
</body>
</html>

