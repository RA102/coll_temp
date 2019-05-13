<?php

/** @var $admissionProtocol \common\models\reception\AdmissionProtocol */
/** @var $uniqueParticipants \common\models\person\Person[] */
/** @var $institution \common\models\organization\Institution */
?>

<article class="wrapper">
    <table style="margin-bottom: 20px">
        <tbody>
        <tr style="font-size: 16pt; text-align: center;">
            <td style="padding: 2mm; width: 95mm; text-align: center;">
                <p style="font-size: 14pt;"><?= $institution->name ?></p>
            </td>
            <td style="text-align: center; width: 95mm; padding: 2mm;">
                <p style="font-size: 14pt;"><?= $institution->name ?></p>
            </td>
        </tr>
        <tr style="font-size: 16pt;">
            <td style="padding: 2mm; font-weight: 700;">
                <p style="font-size: 14pt;"><b>ХАТТАМА № <?= $admissionProtocol->number ?></b></p>
            </td>
            <td style="width: 95mm; padding: 2mm; font-weight: 700">
                <p style="font-size: 14pt;"><b>ПРОТОКОЛ № <?= $admissionProtocol->number ?></b></p>
            </td>
        </tr>
        <tr style="font-size: 16pt; text-align: center;">
            <td style="padding: 2mm; width: 95mm; text-align: center;">
                <p style="font-size: 14pt;"><?= (new DateTime($admissionProtocol->completion_date))->format("d.m.Y") ?>
                    г.</p>
            </td>
            <td style="text-align: center; width: 95mm; padding: 2mm;">
                <p style="font-size: 14pt;"><?= (new DateTime($admissionProtocol->completion_date))->format("d.m.Y") ?>
                    г.</p>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="table-reset" style="margin-bottom: 30px; border: 0; font-size: 12pt">
        <tbody>
        <tr>
            <td colspan="3" style="padding: 2mm 2mm 6mm 2mm; font-size: 16pt">
                Заседание приемной комиссии
            </td>
        </tr>
        <?php foreach ($admissionProtocol->getCommissionMemberLinks() as $commissionMemberLink) { ?>
            <tr style="width: 95mm">
                <td class="empty" style="padding: 2mm; width: 85mm; border-bottom: 1px solid #000;">
                    <p style="font-size: 14pt"><?= $commissionMemberLink->member->getFullName() ?></p>
                </td>
                <td style="width: 10mm">
                    &nbsp;
                </td>
                <td class="empty" style="padding: 2mm; width: 95mm; border-bottom: 1px solid #000;">
                    <p style="font-size: 14pt"><?= $commissionMemberLink->getRoleValue() ?></p>
                </td>
            </tr>
            <tr style="text-align: center; width: 85mm">
                <td style="text-align: center; padding-top: 2mm">
                    (Ф.И.О.)
                </td>
                <td style="width: 10mm">
                    &nbsp;
                </td>
                <td style="text-align: center; width: 95mm; padding-top: 2mm">
                    (должность в приемной комиссии)
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <p style="margin-bottom: 15px; font-size: 14pt;">
        Присутствовали: <?= sizeof($uniqueParticipants) ?> человек</p>
    <p>Список прилагается (см. Приложение 1)</p>
    <p class="ta-center" style="margin-bottom: 10px; font-size: 16pt; text-align: center;">Повестка дня</p>
    <ol>
        <?php foreach ($admissionProtocol->agendas as $agenda) { ?>
            <li><p><?= $agenda ?></p></li>
        <?php } ?>
    </ol>
    <div class="units-row">
        <div class="unit-100">
            <ol>
                <?php foreach ($admissionProtocol->issues as $issueData) { ?>
                    <li style="margin-bottom: 20px;">
                        <p>СЛУШАЛИ:</p>
                        <?php foreach ($issueData['listeners'] as $listener_id) { ?>
                            <p><?= $uniqueParticipants[$listener_id]->getFullName() ?> — текст доклада
                                прилагается</p>
                        <?php } ?>
                        <br>
                        <p>ВЫСТУПИЛИ:</p>
                        <?php foreach ($issueData['speakers'] as $speaker_id) { ?>
                            <p><?= $uniqueParticipants[$speaker_id]->getFullName() ?> — текст доклада
                                прилагается</p>
                        <?php } ?>
                        <p>ПОСТАНОВИЛИ:</p>
                        <p><?= $issueData['decree'] ?></p>
                    </li>
                <?php } ?>
            </ol>
        </div>
    </div>
    <table class="table-reset" style="margin-bottom: 20px; border: 0; font-size: 12pt">
        <tbody>
        <tr style="width: 55mm">
            <td class="empty" style="padding: 2mm; width: 85mm; border-bottom: 1px solid #000;">
                <p style="font-size: 14pt"></p>
            </td>
            <td style="width: 10mm">&nbsp;</td>
            <td class="empty" style="padding: 2mm; width: 50mm; border-bottom: 1px solid #000;">&nbsp;</td>
            <td style="width: 10mm">&nbsp;</td>
            <td class="empty" style="padding: 2mm; width: 55mm; border-bottom: 1px solid #000;">
                <p style="font-size: 14pt"></p>
            </td>
        </tr>
        <tr style="text-align: center; width: 55mm">
            <td style="text-align: center;"></td>
            <td style="width: 10mm">&nbsp;</td>
            <td style="width: 50mm; text-align: center;">(Подпись)</td>
            <td style="width: 10mm">&nbsp;</td>
            <td style="text-align: center; width: 55mm;">(Расшифровка)</td>
        </tr>
        </tbody>
    </table>
    <table class="table-reset" style="margin-bottom: 20px; border: 0; font-size: 12pt">
        <tbody>
        <tr style="width: 55mm">
            <td class="empty" style="padding: 2mm; width: 85mm; border-bottom: 1px solid #000;">
                <p style="font-size: 14pt"></p>
            </td>
            <td style="width: 10mm">&nbsp;</td>
            <td class="empty" style="padding: 2mm; width: 50mm; border-bottom: 1px solid #000;">&nbsp;</td>
            <td style="width: 10mm">&nbsp;</td>
            <td class="empty" style="padding: 2mm; width: 55mm; border-bottom: 1px solid #000;">
                <p style="font-size: 14pt"></p>
            </td>
        </tr>
        <tr style="text-align: center; width: 55mm">
            <td style="text-align: center;"></td>
            <td style="width: 10mm">&nbsp;</td>
            <td style="width: 50mm; text-align: center;">(Подпись)</td>
            <td style="width: 10mm">&nbsp;</td>
            <td style="text-align: center; width: 55mm;">(Расшифровка)</td>
        </tr>
        </tbody>
    </table>
    <htmlpagefooter name="myHTMLFooter">
        <div align="right">{PAGENO}</div>
    </htmlpagefooter>
    <sethtmlpagefooter name="myHTMLFooter" value="on" show-this-page="1"/>
    <pagebreak/>
    <sethtmlpagefooter name="myHTMLFooter" value="off"/>
    <p>Список присутствовавших (Приложение 1)</p>
    <table style="margin-bottom: 20px; border: 0; font-size: 14pt">
        <tbody>
        <tr style="border: 1px solid #000; padding: 2mm;">
            <th style="border: 1px solid #000; padding: 2mm;">Ф.И.О.</th>
            <th style="border: 1px solid #000; padding: 2mm;"></th>
        </tr>
        <?php foreach ($uniqueParticipants as $uniqueParticipant) { ?>
            <tr>
                <td style="padding: 2mm; width: 85mm; border-bottom: 1px solid #000;">
                    <p style="font-size: 14pt">
                        <?= $uniqueParticipant->getFullName() ?>
                    </p>
                </td>
                <td>
                    <p>&nbsp;</p>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</article>


