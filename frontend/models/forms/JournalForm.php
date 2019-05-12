<?php

namespace frontend\models\forms;

use common\helpers\EducationHelper;
use common\helpers\LanguageHelper;
use common\models\handbook\Speciality;
use Yii;
use yii\base\Model;

class JournalForm extends Model
{
    public $education_form;
    public $education_pay_form;
    public $language;
    public $speciality_id;

    public $export = 0;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['speciality_id', 'education_pay_form', 'education_form'], 'integer'],

            ['speciality_id', 'exist', 'targetClass' => Speciality::class, 'targetAttribute' => 'id'],

            ['education_pay_form', 'in', 'range' => array_keys(EducationHelper::getPaymentFormTypes())],
            ['education_form', 'in', 'range' => array_keys(EducationHelper::getEducationFormTypes())],
            ['language', 'in', 'range' => array_keys(LanguageHelper::getLanguageList())],

            ['export', 'in', 'range' => [0,1]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'education_form'     => Yii::t('app', 'Основа обучения'),
            'speciality_id'      => Yii::t('app', 'Speciality ID'),
            'language'           => Yii::t('app', 'Language'),
            'education_pay_form' => Yii::t('app', 'Форма оплаты'),
        ];
    }

    /**
     * @return string
     */
    public function formName()
    {
        return "";
    }
}


