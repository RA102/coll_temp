<?php

namespace frontend\models\forms;

use common\helpers\ApplicationHelper;
use common\helpers\EducationHelper;
use common\helpers\LanguageHelper;
use common\models\handbook\Speciality;
use common\models\reception\Commission;
use Yii;
use yii\base\Model;

class CompetitionEntrantsForm extends Model
{
    public $commission_id;
    public $speciality_id;
    public $education_pay_form;
    public $language;
    public $education_form;
    public $based_classes;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                ['commission_id', 'speciality_id', 'education_pay_form', 'language', 'education_form', 'based_classes'],
                'required'
            ],
            [['commission_id', 'speciality_id', 'education_pay_form', 'education_form', 'based_classes'], 'integer'],

            ['commission_id', 'exist', 'targetClass' => Commission::class, 'targetAttribute' => 'id'],
            ['speciality_id', 'exist', 'targetClass' => Speciality::class, 'targetAttribute' => 'id'],

            ['education_pay_form', 'in', 'range' => array_keys(EducationHelper::getPaymentFormTypes())],
            ['education_form', 'in', 'range' => array_keys(EducationHelper::getEducationFormTypes())],
            ['based_classes', 'in', 'range' => array_keys(ApplicationHelper::getBasedClassesArray())],
            ['language', 'in', 'range' => array_keys(LanguageHelper::getLanguageList())],
        ];
    }

    /**
     * @return string
     */
    public function formName()
    {
        return '';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'education_form'     => Yii::t('app', 'Основа обучения'),
            'speciality_id'      => Yii::t('app', 'Speciality ID'),
            'language'           => Yii::t('app', 'Language'),
            'education_pay_form' => Yii::t('app', 'Форма оплаты'),
            'based_classes'      => Yii::t('app', 'На базе'),
        ];
    }

    /**
     * @return null|Speciality
     */
    public function getSpeciality()
    {
        return $this->speciality_id ? Speciality::findOne($this->speciality_id) : null;
    }

}