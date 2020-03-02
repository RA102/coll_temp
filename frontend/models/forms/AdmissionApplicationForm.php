<?php

namespace frontend\models\forms;

use common\helpers\ApplicationHelper;
use common\models\person\Entrant;
use common\models\person\Person;
use common\models\person\PersonCredential;
use common\models\reception\AdmissionApplication;
use Yii;
use yii\base\Model;

class AdmissionApplicationForm extends Model
{
    const SCENARIO_UPDATE_ACCEPTED_APPLICATION = 'update-accepted-application';

    private $admissionApplication;

    public $iin;

    public $firstname;
    public $lastname;
    public $middlename;

    public $country_id;
    public $sex;
    public $birth_date;
    public $application_date;
    public $nationality_id;
    public $citizenship_location;

    public $is_repatriate;
    public $arrival_location;

    public $email;
    public $contact_phone_home;
    public $contact_phone_mobile;

    public $filing_form;
    public $education_form;
    public $speciality_id;
    public $language;

    public $contract_number;
    public $contract_date;
    public $contract_sum;
    public $contract_duration;

    public $needs_dormitory;
    public $reason_for_dormitory;

    public $education_pay_form;
    public $based_classes;

    public $social_statuses;

    /**
     * AdmissionApplicationForm constructor.
     * @param AdmissionApplication|null $admissionApplication
     * @param array $config
     */
    public function __construct(AdmissionApplication $admissionApplication = null, array $config = [])
    {
        parent::__construct($config);

        if ($admissionApplication) {
            $this->admissionApplication = $admissionApplication;
            $this->setAttributes($admissionApplication->properties);
            if ($admissionApplication->status !== ApplicationHelper::STATUS_CREATED) {
                $this->setScenario(self::SCENARIO_UPDATE_ACCEPTED_APPLICATION);
            }
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['is_repatriate', 'needs_dormitory'], 'default', 'value' => false],

            [
                [
                    'contract_date',
                    'contract_duration',
                    'contract_sum',
                    'social_statuses',
                ],
                'default',
                'value' => null
            ],

            [
                [
                    'iin',
                    'firstname',
                    'lastname',
                    'sex',
                    'birth_date',
                    'application_date',
                    'nationality_id',
                    'citizenship_location',

                    'filing_form',
                    'education_form',
                    'speciality_id',
                    'language',

                    'needs_dormitory',

                    'education_pay_form',
                    'based_classes'
                ],
                'required'
            ],

            [
                'reason_for_dormitory',
                'required',
                'when'                   => function () {
                    return $this->needs_dormitory == true;
                },
                'enableClientValidation' => false
            ],
            [
                'arrival_location',
                'required',
                'when'                   => function () {
                    return $this->is_repatriate == true;
                },
                'enableClientValidation' => false
            ],

            [['iin'], 'string', 'length' => 12],
            [['iin'], 'match', 'pattern' => '/^\d{12}$/'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 100],
            [['sex'], 'in', 'range' => [Entrant::SEX_NONE, Entrant::SEX_MALE, Entrant::SEX_FEMALE]],
            [['language'], 'string', 'min' => 2, 'max' => 2],

            ['contract_number', 'string', 'max' => '20'],
            [['contract_date'], 'date', 'format' => 'php:Y-m-d'],
            ['contract_sum', 'integer'],
            ['contract_duration', 'integer', 'min' => 0],

            ['social_statuses', 'validateSocialStatuses', 'skipOnEmpty' => true],

            // [
            //     'iin',
            //     //'unique',
            //     'targetClass' => Person::class,
            //     'on'          => self::SCENARIO_DEFAULT
            // ],

            ['email', 'safe'],
            [
                'email',
                'unique',
                'targetClass'     => PersonCredential::class,
                'targetAttribute' => 'indentity',
                'on'              => self::SCENARIO_DEFAULT
            ],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE_ACCEPTED_APPLICATION] = [
            '!firstname',
            '!lastname',
            '!middlename',
            '!iin',
            '!birth_date',
            '!sex',
            '!nationaltity_id',
            '!citizenship_location',

            'email',

            '!filing_form',
            '!education_form',
            'speciality_id',
            '!language',

            '!needs_dormitory',
            '!reason_for_dormitory',

            '!education_pay_form',
            '!based_classes',

            '!contract_number',
            '!contract_date',
            '!contract_sum',
            '!contract_duration'
        ];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'firstname'            => Yii::t('app', 'Firstname'),
            'lastname'             => Yii::t('app', 'Lastname'),
            'middlename'           => Yii::t('app', 'Middlename'),
            'iin'                  => Yii::t('app', 'Iin'),
            'birth_date'           => Yii::t('app', 'Birth Date'),
            'sex'                  => Yii::t('app', 'Sex'),
            'nationality_id'       => Yii::t('app', 'Nationality ID'),
            'citizenship_location' => Yii::t('app', 'Гражданство'),
            'application_date'     => Yii::t('app', 'Дата заявки'),
            'is_repatriate'        => Yii::t('app', 'Оралман\Беженец'),
            'arrival_location'     => Yii::t('app', 'Откуда приехал'),

            'email'                => Yii::t('app', 'Email'),
            'contact_phone_home'   => Yii::t('app', 'Home Phone'),
            'contact_phone_mobile' => Yii::t('app', 'Mobile Phone'),


            'filing_form'    => Yii::t('app', 'Заявка подана'),
            'education_form' => Yii::t('app', 'Основа обучения'),
            'speciality_id'  => Yii::t('app', 'Speciality ID'),
            'language'       => Yii::t('app', 'Language'),

            'contract_number'   => Yii::t('app', 'Номер договора'),
            'contract_date'     => Yii::t('app', 'Дата договора'),
            'contract_sum'      => Yii::t('app', 'Сумма договора'),
            'contract_duration' => Yii::t('app', 'Срок действия договора'),

            'needs_dormitory'      => Yii::t('app', 'Необходимость в общежитии'),
            'reason_for_dormitory' => Yii::t('app', 'Причина'),

            'education_pay_form' => Yii::t('app', 'Форма оплаты'),
            'based_classes'      => Yii::t('app', 'На базе'),

            'social_statuses' => Yii::t('app', 'Льготы'),
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validateSocialStatuses($attribute, $params)
    {
        $value = $this->{$attribute};
        if (!is_array($value)) {
            $this->addError($attribute, 'Некоректный тип данных для льгот');
        }

        foreach ($value as $i => $social_status) {
            if (empty($social_status['name'])) {
                $this->addError("{$attribute}[{$i}][name]", 'Некоректное наименование для льгот');
            }
        }
    }
}