<?php

namespace common\helpers;

use common\models\person\Person;
use Yii;

class PersonInfoHelper
{
    # типы информативных данных пользователя
    const FILE_NUMBER = 'file_number'; // Номер личного дела
    const RNN = 'rnn'; // РНН
    const SIK = 'sik'; // СИК
    const FAMILY_STATUS = 'family_status'; // Семейное

    # свидетельство о рождении
    const BIRTH_CERTIFICATE_SERIES = 'birth_certificate_series'; // Серия свидетельства о рождении
    const BIRTH_CERTIFICATE_NUMBER = 'birth_certificate_number'; // Номер свидетельства о рождении
    const BIRTH_CERTIFICATE_ISSUED_DATE = 'birth_certificate_issued_date'; // Дата выдачи свидетельства

    # удв
    const IDENTITY_CARD_NUMBER = 'identity_card_number'; // Номер УДВ
    const IDENTITY_CARD_ISSUED = 'identity_card_issued'; // Кем выдано УДВ
    const IDENTITY_CARD_ISSUED_DATE = 'identity_card_issued_date'; // Дата выдачи УДВ
    const IDENTITY_CARD_VALID_DATE = 'identity_card_valid_date'; // УДВ действтельно до

    # паспорт
    const PASSPORT_SERIES = 'passport_series'; // Серия паспорта
    const PASSPORT_ISSUED = 'passport_issued'; // Кем выдано
    const PASSPORT_NUMBER = 'passport_number'; // Номер паспорта
    const PASSPORT_ISSUED_DATE = 'passport_issued_date'; // Дата выдачи
    const PASSPORT_VALID_DATE = 'passport_valid_date'; // Паспорт действтелен до

    # вид на жительство иностранца
    const TEMPORARY_STAY_ISSUED = 'temporary_stay_issued'; // Кем выдано
    const TEMPORARY_STAY_NUMBER = 'temporary_stay_number'; // Номер
    const TEMPORARY_STAY_ISSUED_DATE = 'temporary_stay_issued_date'; // Дата выдачи
    const TEMPORARY_STAY_VALID_DATE = 'temporary_stay_valid_date'; // действтелен до

    # удостоверение лица без гражданства
    const WITHOUT_CITIZENSHIP_IDENTITY_CARD_ISSUED = 'without_citizenship_identity_card_issued'; // Кем выдано
    const WITHOUT_CITIZENSHIP_IDENTITY_CARD_NUMBER = 'without_citizenship_identity_card_number'; // Номер
    const WITHOUT_CITIZENSHIP_IDENTITY_CARD_ISSUED_DATE = 'without_citizenship_identity_card_issued_date'; // Дата выдачи
    const WITHOUT_CITIZENSHIP_IDENTITY_CARD_VALID_DATE = 'without_citizenship_identity_card_valid_date'; // действтелен до

    # удостоверение беженца
    const REFUGEE_IDENTITY_CARD_ISSUED = 'refugee_identity_card_issued'; // Кем выдано
    const REFUGEE_IDENTITY_CARD_NUMBER = 'refugee_identity_card_number'; // Номер
    const REFUGEE_IDENTITY_CARD_ISSUED_DATE = 'refugee_identity_card_issued_date'; // Дата выдачи
    const REFUGEE_IDENTITY_CARD_VALID_DATE = 'refugee_identity_card_valid_date'; // действтелен до

    # удостоверение лица ищущего убежище
    const SHELTER_SEEKER_IDENTITY_CARD_ISSUED = 'shelter_seeker_identity_card_issued'; // Кем выдано
    const SHELTER_SEEKER_IDENTITY_CARD_NUMBER = 'shelter_seeker_identity_card_number'; // Номер
    const SHELTER_SEEKER_IDENTITY_CARD_ISSUED_DATE = 'shelter_seeker_identity_card_issued_date'; // Дата выдачи
    const SHELTER_SEEKER_IDENTITY_CARD_VALID_DATE = 'shelter_seeker_identity_card_valid_date'; // действтелен до

    # удостоверение оралмана
    const RETURNER_IDENTITY_CARD_ISSUED = 'returner_identity_card_issued'; // Кем выдано
    const RETURNER_IDENTITY_CARD_NUMBER = 'returner_identity_card_number'; // Номер
    const RETURNER_IDENTITY_CARD_ISSUED_DATE = 'returner_identity_card_issued_date'; // Дата выдачи
    const RETURNER_IDENTITY_CARD_VALID_DATE = 'returner_identity_card_valid_date'; // действтелен до

    # отношение к военской службе
    # TODO - было удалено, вернул для импорта обдумать нужность
    const MILITARY_SERVICE_ARMY_TYPE = 'military_service_army_type'; // Тип войск
    const MILITARY_SERVICE_RELATIONSHIP = 'military_service_relationship'; //  Отношение к воиской службе
    const MILITARY_SERVICE_RANK = 'military_service_rank'; // Зание

    # вид пенсии
    # TODO - было удалено, вернул для импорта обдумать нужность
    const PENSION_TYPE = 'pension_type'; // Вид пенсии
    const PENSION_TYPE_PRIVILEGED = 'privileged_pension'; //  льготная
    const PENSION_TYPE_AGE = 'age_pension'; //  возростная
    const PENSION_TYPE_INVALID = 'invalid_pension'; //  инвалидная
}
