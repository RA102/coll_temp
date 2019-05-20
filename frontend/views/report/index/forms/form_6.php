<?php

/** @var $entranceExamsReportForm \frontend\models\forms\EntranceExamsReportForm */
/** @var $entrants \common\models\person\Entrant[] */
/** @var $secretary \common\models\person\Person */
/** @var $speciality \common\models\handbook\Speciality */
/** @var $receptionGroup \common\models\ReceptionGroup */
/** @var $this \yii\web\View */

?>
<htmlpagefooter name="myHTMLFooter">
    <div align="center">{PAGENO}</div>
</htmlpagefooter>
<sethtmlpagefooter name="myHTMLFooter" value="on" show-this-page="1"/>

<article class="wrapper">
    <div class="units-row">
        <div class="unit-100 ta-center">
            <h1 style="font-weight: bold; text-align: center">
                Ведомость вступительных экзаменов<br>
                в форме тестирования или экзамена
            </h1>
        </div>

        <?php if ($speciality) { ?>
            <p style="width: 100%; margin-bottom: 0">
                <span style="float: left; margin-right: 5mm">Специальность:</span>
                <span style="display: inline; width: 100%; text-decoration: underline; text-underline-position: under">
                <?= "{$speciality->code} - {$speciality->caption_current} " ?>
            </span>
            </p>
        <?php } else { ?>
            <p style="display: table; width: 100%; margin-bottom: 0">
            <div style="display: table-row;">
                <span style="display: table-cell;">Специальность:</span>
                <span style="display: table-cell;"></span>
            </div>
            </p>
            <div style="display: block; width: 100%; border-bottom: 1pt solid black;"></div>
        <?php } ?>

        <p style="text-align: center;"><span style="font-size: 12pt"><i>(код и название специальностии)</i></span></p>

        <?php if (isset($speciality->parent)) { ?>
            <p style="width: 100%; margin-bottom: 0">
                <span style="float: left; margin-right: 5mm">Квалификация:</span>
                <span style="display: inline; width: 100%; text-decoration: underline; text-underline-position: under;">
                <?= "{$speciality->parent->code} - {$speciality->parent->caption_current} " ?>
            </span>
            </p>
        <?php } else { ?>
            <p style="display: table; width: 100%; margin-bottom: 0">
            <div style="display: table-row">
                <span style="display: table-cell;">Квалификация:</span>
                <span style="display: table-cell; border-bottom: 1pt solid black;"></span>
            </div>
            </p>
            <div style="display: block; width: 100%; border-bottom: 1pt solid black;">&nbsp;</div>
        <?php } ?>

        <p style="text-align: center;"><span style="font-size: 12pt"><i>(код и название квалификации)</i></span></p>

        <p style="margin-bottom: 0">Форма обучения:
            <span style="text-decoration: underline; text-underline-position: under;">
                <?= \common\helpers\EducationHelper::getEducationFormTypes()[$entranceExamsReportForm->education_form] ?>
            </span>
        </p>
        <p style="margin-bottom: 0">Основа обучения:
            <span style="text-decoration: underline; text-underline-position: under;">
                <?= \common\helpers\EducationHelper::getPaymentFormTypes()[$entranceExamsReportForm->education_pay_form] ?>
            </span>
        </p>
        <p style="margin-bottom: 0">Язык обучения:
            <span style="text-decoration: underline; text-underline-position: under;">
                <?= \common\helpers\LanguageHelper::getLanguageList()[$entranceExamsReportForm->language] ?>
            </span>
        </p>
        <p style="margin-bottom: 0">Дата тестирования/экзамена
            <span>_________________________г.</span>
        </p>
        <?php foreach ($receptionGroup->receptionExams as $index => $receptionExam) { ?>
            <p style="margin-bottom: 0">Предмет №<?= $index + 1 ?>:
                <span style="text-decoration: underline; text-underline-position: under;">
                    <?= $receptionExam->institutionDiscipline->caption_current ?>
                </span>
            </p>
        <?php } ?>
    </div>

    <div class="units-row">
        <table style="font-size: 14pt">
            <thead style="font-weight: bold">
            <tr>
                <td style="font-weight: bold;">№</td>
                <td style="font-weight: bold;">Ф.И.О.</td>
                <td style="font-weight: bold;">Вариант</td>
                <?php foreach ($receptionGroup->receptionExams as $index => $receptionExam) { ?>
                    <td style="font-weight: bold;">Предмет №<?= $index + 1 ?></td>
                <?php } ?>
                <td style="font-weight: bold;">Всего набрано балло Цифра (пропись)</td>
            </tr>

            </thead>
            <tbody>
            <?php foreach ($entrants as $entrantIndex => $entrant) { ?>
                <?php $entrantTotalPoints = 0; ?>
                <tr>
                    <td style="text-align: center;"><?= $entrantIndex + 1 ?></td>
                    <td><?= $entrant->getFullName() ?></td>
                    <td style="text-align: center;"></td>
                    <?php foreach ($receptionGroup->receptionExams as $receptionExamIndex => $receptionExam) { ?>
                        <td style="text-align: center;">
                            <?php if (isset($entrant->indexedReceptionExamGrades[$receptionExam->id])
                                && $entrant->indexedReceptionExamGrades[$receptionExam->id]->points > 0) {
                                $entrantTotalPoints += $entrant->indexedReceptionExamGrades[$receptionExam->id]->points;
                                echo Yii::$app->formatter->asSpellout($entrant->indexedReceptionExamGrades[$receptionExam->id]->points);
                            }
                            ?>
                        </td>
                    <?php } ?>
                    <td style="text-align: center;">
                        <?= $entrantTotalPoints > 0 ? Yii::$app->formatter->asSpellout($entrantTotalPoints) : ""; ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="units-row">
        <table class="table" style="width: 0; vertical-align: bottom;">
            <tr>
                <td>
                    <p>Ответственный секретарь приемной комиссии:</p>
                </td>
                <td>
                    <table class="table" style="width: 0; vertical-align: bottom;">
                        <tr>
                            <td>____________</td>
                            <td>
                                <?php if ($secretary) { ?>
                                    <div style="margin-bottom: 0; text-decoration: underline; text-underline-position: under; white-space: nowrap;">
                                        <?= $secretary->getFullName() ?>
                                    </div>
                                <?php } else { ?>
                                    <span style="margin-bottom: 0;">__________________________________________________________</span>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 12pt; text-align: center; padding: 0; margin: 0;">
                                <span><i>(подпись)</i></span>
                            </td>
                            <td style="font-size: 12pt; text-align: center; padding: 0; margin: 0;">
                                <span><i>(Ф.И.О.)</i></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="units-row">
        <?= date("d.m.Y") ?>г.
    </div>
</article>