<?php

namespace common\helpers;

use Yii;

class EducationHelper
{

    const EDUCATION_PAY_FORM_BUDGET = 1; //бюджет
    const EDUCATION_PAY_FORM_CONTRACT = 2; //договор
    const EDUCATION_PAY_FORM_MIXED = 3; //смешанная

    const EDUCATION_FORM_FULL_TIME = 1; //очное
    const EDUCATION_FORM_EXTRAMURAL = 2; // заочное
    const EDUCATION_FORM_EVENING = 3; // вечернее

    const EDUCATION_TYPE_INCOMPLETE_AVERAGE = 1; // Незаконченное среднее (Основное среднее)
    const EDUCATION_TYPE_MIDDLE = 2; // среднее (общее среднее)
    const EDUCATION_TYPE_INITIAL_PROFESSIONAL = 3; // Начальное профессиональное (Техническое и профессиональное)
    const EDUCATION_TYPE_SPECIALIZED_SECONDARY = 4; // Среднее специальное
    const EDUCATION_TYPE_AFTER_MIDDLE = 5; // послесреднее
    const EDUCATION_TYPE_HIGH = 6; // высшее

    /**
     * Массив формы обучения
     *
     * @return array
     */
    public static function getEducationFormTypes()
    {
        return [
            self::EDUCATION_FORM_FULL_TIME  => Yii::t('app', 'Очное'),
            self::EDUCATION_FORM_EXTRAMURAL => Yii::t('app', 'Заочное'),
            self::EDUCATION_FORM_EVENING    => Yii::t('app', 'Вечернее')
        ];
    }

    /**
     * Массив формы оплаты
     *
     * @return array
     */
    public static function getPaymentFormTypes()
    {
        return [
            self::EDUCATION_PAY_FORM_BUDGET   => Yii::t('app', 'Бюджетная'),
            self::EDUCATION_PAY_FORM_CONTRACT => Yii::t('app', 'Договор'),
            self::EDUCATION_PAY_FORM_MIXED    => Yii::t('app', 'Смешанная')
        ];
    }
}