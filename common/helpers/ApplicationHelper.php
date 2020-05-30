<?php

namespace common\helpers;

use Yii;

class ApplicationHelper
{
    const APPLICATION_TYPE_ADMISSION = 1; // заявка на принятие в организацию
    const APPLICATION_TYPE_INSTITUTION = 2; // заявка организации на подключение к системе
    const APPLICATION_TYPE_APPEALS = 3; //заявка на апелляцию
    const APPLICATION_TYPE_APPEALS_MEETING = 4; //заседание апелляционной комиссии
    const APPLICATION_TYPE_ADMISSION_MEETING = 5; //заседание приемной комиссии
    const APPLICATION_TYPE_ATTESTATION_PEDAT = 6; //заявка на аттестацию педата
    const APPLICATION_TYPE_ADMISSION_ORDER = 7; //приказ о зачислении

    const STATUS_CREATED = 0; // создано
    const STATUS_CONFIRMATION = 1; // подтверждение
    const STATUS_ACCEPTED = 2; // принято
    const STATUS_DECLINED = 3; // отказано
    const STATUS_ENLISTED = 4; // зачисление
    const STATUS_WITHDRAWN = 5; // отозвано
    const STATUS_DELETED = 6; // удалено

    const BASED_CLASSES_NINE = 1; //на базе 9 классов
    const BASED_CLASSES_ELEVEN = 2; // на базе 11 классов
    const BASED_CLASSES_TIPO_CORRESPONDS_TO_PROFILE = 3; // ТиПО соотв. профилю
    const BASED_CLASSES_TIPO_DOES_NOT_MATCH_PROFILE = 4; // ТиПО не соотв. профилю

    const ONLINE_NO = 0;
    const ONLINE_EGOV = 1;
    const ONLINE_BILIMAL = 2;

    public static $list = [
        self::STATUS_CREATED      => 'Создано',
        self::STATUS_CONFIRMATION => 'Подтверждено',
        self::STATUS_ACCEPTED     => 'Зарегистрировано',
        self::STATUS_DECLINED     => 'Отказано',
        self::STATUS_ENLISTED     => 'Зачислено',
        self::STATUS_WITHDRAWN    => 'Отозвано',
        self::STATUS_DELETED      => 'Удалено',
    ];

    /**
     * Значение базы обучения
     *
     * @param $type
     *
     * @return string
     */
    public static function getBasedClassesLabel($type)
    {
        $a = self::getBasedClassesArray();
        if (!$a[$type]) {
            return null;
        }

        return $a[$type];
    }

    /**
     * Массив базы обучения
     *
     * @return array
     */
    public static function getBasedClassesArray()
    {
        return [
            self::BASED_CLASSES_NINE                        => Yii::t('app', 'На базе 9 классов'),
            self::BASED_CLASSES_ELEVEN                      => Yii::t('app', 'На базе 11 классов'),
            self::BASED_CLASSES_TIPO_CORRESPONDS_TO_PROFILE => Yii::t('app', 'ТиПО соотв. профилю'),
            self::BASED_CLASSES_TIPO_DOES_NOT_MATCH_PROFILE => Yii::t('app', 'ТиПО не соотв. профилю'),
        ];
    }

    /**
     * @return array
     */
    public static function getAdmissionApplicationStatusLabels()
    {
        return [
            self::STATUS_CREATED   => Yii::t('app',
                'Принято (принята онлайн заявка, ожидает заявление абитуриента и документов)'),
            self::STATUS_ACCEPTED  => Yii::t('app',
                'Зарегистрировано  (принят полный пакет документов) при этом статусе идет распределение по группам)'),
            self::STATUS_DECLINED  => Yii::t('app', 'Отказано (указывается причина)'),
            self::STATUS_WITHDRAWN => Yii::t('app', 'Отозвано (указывается основание)'),
            self::STATUS_DELETED   => Yii::t('app', 'Удалено')
        ];
    }


    public static function getAdmissionApplicationOnlineLabels()
    {
        return [
            self::ONLINE_NO => Yii::t('app', 'Нет'),
            self::ONLINE_EGOV => Yii::t('app', 'Гос.портал'),
            self::ONLINE_BILIMAL => Yii::t('app', 'Bilimal')
        ];
    }
}