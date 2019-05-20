<?php

namespace frontend\models\forms;

use common\helpers\ApplicationHelper;
use common\helpers\EducationHelper;
use common\helpers\LanguageHelper;
use common\models\handbook\Speciality;
use common\models\ReceptionExam;
use Yii;
use yii\base\Model;

/**
 * Class ReportForm
 * @package frontend\models\forms
 */
class EntranceExamsReportForm extends Model
{
    const FORM_4 = 4; //Форма 4 «Ведомость вступительных экзаменов в форме тестирования или экзамена на базе основного образования»
    const FORM_5 = 5; //Форма 5 «Ведомость вступительных экзаменов в форме тестирования или экзамена на базе основного среднего образования»
    const FORM_6 = 6; //Форма 6 «Ведомость вступительных экзаменов в форме тестирования или экзамена на базе технического и профессионального, послесреднего, высшего, не соответсующего профилю специальности»
    const FORM_7 = 7; //Форма 7 «Ведомость вступительных экзаменов в форме собеседования»
    const FORM_8 = 8; //Форма 8 «Ведомость вступительных экзаменов в форме специальных или творческих экзаменов по программам»
    public static $formTypeToExamTypes = [
        self::FORM_4 => [ReceptionExam::TYPE_EXAM, ReceptionExam::TYPE_TEST],
        self::FORM_5 => [ReceptionExam::TYPE_EXAM, ReceptionExam::TYPE_TEST],
        self::FORM_6 => [ReceptionExam::TYPE_EXAM, ReceptionExam::TYPE_TEST],
        self::FORM_7 => [ReceptionExam::TYPE_INTERVIEW],
        self::FORM_8 => [ReceptionExam::TYPE_CREATIVE],
    ];
    public static $formTypeToBasedClasses = [
        self::FORM_4 => [ApplicationHelper::BASED_CLASSES_NINE],
        self::FORM_5 => [ApplicationHelper::BASED_CLASSES_ELEVEN],
        self::FORM_6 => [
            ApplicationHelper::BASED_CLASSES_TIPO_CORRESPONDS_TO_PROFILE,
            ApplicationHelper::BASED_CLASSES_TIPO_DOES_NOT_MATCH_PROFILE,
        ],
    ];
    public $based_classes;
    public $education_form;
    public $education_pay_form;
    public $exam_types;
    public $language;
    public $speciality_id;
    public $type;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['education_form', 'education_pay_form', 'language', 'speciality_id', 'type'], 'required'],
            [['based_classes', 'education_form', 'education_pay_form', 'speciality_id', 'type'], 'integer'],

            [
                'based_classes',
                'required',
                'when'                   => function ($data) {
                    return in_array($this->type, [self::FORM_7, self::FORM_8]);
                },
                'enableClientValidation' => false
            ],
            ['based_classes', 'in', 'range' => array_keys(ApplicationHelper::getBasedClassesArray())],
            ['education_form', 'in', 'range' => array_keys(EducationHelper::getEducationFormTypes())],
            ['education_pay_form', 'in', 'range' => array_keys(EducationHelper::getPaymentFormTypes())],
            ['language', 'in', 'range' => array_keys(LanguageHelper::getLanguageList())],
            ['type', 'in', 'range' => array_keys(self::getListOfForms())],
            ['speciality_id', 'exist', 'targetClass' => Speciality::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @return array
     */
    public static function getListOfForms()
    {
        return [
            self::FORM_4 => "Форма 4 «Ведомость вступительных экзаменов в форме тестирования или экзамена на базе основного образования»",
            self::FORM_5 => "Форма 5 «Ведомость вступительных экзаменов в форме тестирования или экзамена на базе основного среднего образования»",
            self::FORM_6 => "Форма 6 «Ведомость вступительных экзаменов в форме тестирования или экзамена на базе технического и профессионального, послесреднего, высшего, не соответсующего профилю специальности»",
            self::FORM_7 => "Форма 7 «Ведомость вступительных экзаменов в форме собеседования»",
            self::FORM_8 => "Форма 8 «Ведомость вступительных экзаменов в форме специальных или творческих экзаменов по программам»"
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'education_form'     => Yii::t('app', 'Основа обучения'),
            'speciality_id'      => Yii::t('app', 'Speciality ID'),
            'language'           => Yii::t('app', 'Language'),
            'education_pay_form' => Yii::t('app', 'Форма оплаты'),
            'based_classes'      => Yii::t('app', 'На базе'),
            'type'               => Yii::t('app', 'Форма отчетности')
        ];
    }

    /**
     *
     */
    public function afterValidate()
    {
        if (!$this->hasErrors()) {
            if (in_array($this->type, array_keys(self::$formTypeToBasedClasses))) {
                $this->based_classes = self::$formTypeToBasedClasses[$this->type];
            } else {
                $this->based_classes = [$this->based_classes];
            }

            $this->exam_types = self::$formTypeToExamTypes[$this->type];
        }
    }

    public function getViewName(): string
    {

    }
}