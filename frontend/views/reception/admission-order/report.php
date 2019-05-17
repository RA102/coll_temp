<?php
/* @var $this \yii\web\View */
/* @var $form \frontend\models\forms\AdmissionOrderForm */
/* @var $institution \common\models\organization\Institution */
/* @var $sortedApplications [] */

use common\helpers\ApplicationHelper;
use common\helpers\EducationHelper;
use common\helpers\LanguageHelper;
use common\helpers\ReceptionExamHelper; ?>

<article class="wrapper">
    <p style="font-size: 15pt; text-align: right; margin-bottom: 20px; padding-top: 0">
        <b>&laquo;Приказ  о зачислении&raquo;</b><br>
        <?=$institution->name?>
    </p>

    <div class="units-row">
        <div class="unit-50 ta-left">
            <p>БҰЙРЫҚ</p>
            <p class="margin-0">Дата <span style="text-decoration: underline;"><?=date('d.m.Y', strtotime($form->date))?>г.</span></p>
            <p>№ <span style="text-decoration: underline;"><?=$form->protocol_number?></span></p>
        </div>
        <div class="unit-50 ta-right">
            <p>ПРИКАЗ</p>
        </div>
    </div>

    <div class="units-row">
        <div class="unit-100">
            <p class="margin-0" style="font-size: 12pt; text-indent: 1.5em; text-align: justify;">В соответствии с Типовыми правилами приема на обучение в организации образования и Правилами
                приема на обучение в <em><?=$institution->name?></em>, реализующих образовательные программы технического и профессионального
                образования и на основании решения приемной комиссии</p>
            <p class="margin-0" style="font-size: 13pt"><b>ПРИКАЗЫВАЮ</b></p>
            <?php foreach($sortedApplications as $sortedApplication):?>
            <p style=" font-size: 12pt; text-indent: 1.5em">
                зачислить в число студентов колледжа, следующих абитуриентов поступающих на
                <em>
                    <span style="text-decoration: underline; "><?=EducationHelper::getEducationFormTypes()[$form->education_form]?></span> (форма обучения),
                    <span style="text-decoration: underline; "><?=EducationHelper::getPaymentFormTypes()[$form->education_pay_form]?></span> (основа обучения),
                    <span style="text-decoration: underline; "><?=ApplicationHelper::getBasedClassesArray()[$form->based_classes]?></span> (база образования),
                    <span style="text-decoration: underline; "><?=LanguageHelper::getLanguageList()[$form->language];?></span> (язык обучения)
                </em>
                успешно прошедших
                <em>
                    <span style="text-decoration: underline; "><?=ReceptionExamHelper::getTypeList()[$form->exam_form]?></span> (форма вступительного экзамена)
                </em>:
            </p>

            <p style="text-indent: 1.5em;">
                по специальности <em><?=$sortedApplication['group']->speciality->parent->getCaptionWithCode()?></em> с присвоением квалификации
                <em><?=$sortedApplication['group']->speciality->getCaptionWithCode()?></em>
            </p>
            <p style="text-indent: 1.5em;">
                в группу <em><?=$sortedApplication['group']->caption_current?> </em>
            </p>
            <ol>
                <?php foreach ($sortedApplication['applications'] as $application):?>
                <li><?=$application->student->getFullName()?></li>
                <?php endforeach;?>
            </ol>

            <?php endforeach;?>
        </div>
    </div>

    <table class="table" style="vertical-align: bottom;">
        <tr>
            <td>
                Директор:
            </td>
            <td style="text-align: center;">____________</td>
            <td style="text-align: center;">
<!--                {% if director %}-->
<!--                <div style="margin-bottom: 0; text-decoration: underline; text-underline-position: under; white-space: nowrap;">{{ director.firstname }} {{ director.lastname }} {{ director.middlename }}</div>-->
<!--                {% else %}-->
                <span style="margin-bottom: 0;">__________________________________________________________</span>
<!--                {% endif %}-->
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td style="font-size: 12pt; text-align: center; padding: 0; margin: 0;">
                <span><i>(подпись)</i></span>
            </td>
            <td style="font-size: 12pt; text-align: center; padding: 0; margin: 0;">
                <span><i>(Ф.И.О.)</i></span>
            </td>
        </tr>
    </table>
</article>
