<?php
/** @var $admissionApplication \common\models\reception\AdmissionApplication */
/** @var $speciality \common\models\handbook\Speciality */

$checkReceiptDocumentExistence = function ($parameterName) use ($admissionApplication) {
    return isset($admissionApplication->receipt[$parameterName])
        && $admissionApplication->receipt[$parameterName] > 0;
};
?>

<article class="wrapper">
    <div class="ta-center margin-20">
        <h1><?= $admissionApplication->institution->name ?></h1>
        <h3>Расписка № <?= $admissionApplication->id ?></h3>
    </div>
    <div class="units-row">
        <p>О приёме документов на специальность: <?= $speciality->caption_current ?></p>
        <p>От: <?= $admissionApplication->person->getFullName() ?></p>
    </div>
    <div class="ta-center margin-20">
        <h3>Приняты документы</h3>
    </div>
    <div class="units-row">
        <ol>
            <?php if ($checkReceiptDocumentExistence('applications_count')) { ?>
                <li>Заявление в колледж</li>
            <?php } ?>
            <?php if ($checkReceiptDocumentExistence('school_certificates_count')) { ?>
                <li>Подлинник документа об образовании</li>
            <?php } ?>
            <?php if ($checkReceiptDocumentExistence('medical_certificates_count')) { ?>
                <li>Медицинская справка по форме № 086- У с приложением флюроснимка</li>
            <?php } ?>
            <?php if ($checkReceiptDocumentExistence('medical_commission_opinions_count')) { ?>
                <li>Заключение медико-социальной экспертной комиссии (для инвалидов I и II
                    группы и инвалидов детства)
                </li>
            <?php } ?>
            <?php if ($checkReceiptDocumentExistence('photos_count')) { ?>
                <li>Фотокарточка 3x4 см</li>
            <?php } ?>
            <?php if ($checkReceiptDocumentExistence('ent_certificates_count')) { ?>
                <li>Сертификат ЕНТ</li>
            <?php } ?>
        </ol>
    </div>

    <div class="units-row">
        <div class="unit-100">
            "_____" _____________________ 20___год
        </div>
        <div class="unit-100">
            Секретарь приёмной комиссии
        </div>
    </div>

    <div class="units-row">
        <p>ФИО _________________________________________</p>
    </div>

    <div class="units-row margin-0">
        <p>Примечание: В случае потери расписки поступающий немедленно заявляет
            об этом в приёмную комиссию колледжа.</p>
    </div>
</article>