<?php

namespace frontend\models\forms;

use common\components\ActiveForm;
use common\helpers\PersonContactHelper;
use common\helpers\PersonLocationHelper;
use common\models\person\Person;
use common\models\person\PersonLocation;
use common\services\person\PersonContactService;
use common\services\person\PersonLocationService;
use Yii;
use yii\base\Model;
use yii\web\Application;

class PersonContactsForm extends Model
{
    public $contact_phone_home;
    public $contact_phone_mobile;

    public $registration_country_id;
    public $registration_city_ids = [];
    public $registration_street_id;

    public $residence_country_id;
    public $residence_city_ids = [];
    public $residence_street_id;

    public $citizenship_country_id;


    public function __construct(
        Person $person,
        PersonContactService $personContactService,
        PersonLocationService $personLocationService,
        array $config = [])
    {
        $this->contact_phone_home = $personContactService->getContactValue($person, PersonContactHelper::PHONE_HOME);
        $this->contact_phone_mobile = $personContactService->getContactValue($person, PersonContactHelper::PHONE_MOBILE);

        // citizenship
        $personLocationCitizenship = $personLocationService->getLocation($person, PersonLocationHelper::TYPE_CITIZENSHIP);
        if ($personLocationCitizenship) {
            $this->citizenship_country_id = $personLocationCitizenship->country_id;
        }

        // registration
        $personLocationRegistration = $personLocationService->getLocation($person, PersonLocationHelper::TYPE_REGISTRATION);
        if ($personLocationRegistration) {
            $this->registration_country_id = $personLocationRegistration->country_id;
            $this->registration_city_ids = $personLocationRegistration->getCountryUnitIds();
            $this->registration_street_id = $personLocationRegistration->street_id;
        }

        // residence
        $personLocationResidence = $personLocationService->getLocation($person, PersonLocationHelper::TYPE_RESIDENCE);
        if ($personLocationResidence) {
            $this->residence_country_id = $personLocationResidence->country_id;
            $this->residence_city_ids = $personLocationResidence->getCountryUnitIds();
            $this->residence_street_id = $personLocationResidence->street_id;
        }

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact_phone_home'], 'string'],
            [['contact_phone_mobile'], 'string'],
            [['registration_country_id'], 'required'],
            [['registration_country_id', 'registration_city_ids', 'registration_street_id'], 'safe'],
            [['residence_country_id'], 'required'],
            [['residence_country_id', 'residence_city_ids', 'residence_street_id'], 'safe'],
            [['citizenship_country_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'contact_phone_home' => 'Домашний телефон',
            'contact_phone_mobile' => 'Мобильный телефон',
            'location_registration' => 'Адрес прописки',
            'registration_country_id' => 'Адрес прописки',
            'location_residence' => 'Домашний адрес',
            'residence_country_id' => 'Домашний адрес',
            'citizenship_country_id' => 'Гражданство',
        ];
    }

    public function apply(Person $person, PersonContactService $personContactService, PersonLocationService $personLocationService)
    {
        $personContactService->setContactValue($person, PersonContactHelper::PHONE_HOME, $this->contact_phone_home);
        $personContactService->setContactValue($person, PersonContactHelper::PHONE_MOBILE, $this->contact_phone_mobile);

        // citizenship
        $personLocationCitizenship = $personLocationService->getLocation($person, PersonLocationHelper::TYPE_CITIZENSHIP);
        if (!$personLocationCitizenship) {
            $personLocationCitizenship = new PersonLocation();
        }
        $personLocationCitizenship->country_id = $this->citizenship_country_id;
        $personLocationCitizenship->type = PersonLocationHelper::TYPE_CITIZENSHIP;

        $personLocationService->setLocation($person, $personLocationCitizenship);

        // registration
        $personLocationRegistration = $personLocationService->getLocation($person, PersonLocationHelper::TYPE_REGISTRATION);
        if (!$personLocationRegistration) {
            $personLocationRegistration = new PersonLocation();
        }
        $personLocationRegistration->country_id = $this->registration_country_id;
        $personLocationRegistration->country_unit_id = end($this->registration_city_ids);
        $personLocationRegistration->street_id = $this->registration_street_id;
        $personLocationRegistration->type = PersonLocationHelper::TYPE_REGISTRATION;

        $personLocationService->setLocation($person, $personLocationRegistration);

        // residence
        $personLocationResidence = $personLocationService->getLocation($person, PersonLocationHelper::TYPE_RESIDENCE);
        if (!$personLocationResidence) {
            $personLocationResidence = new PersonLocation();
        }
        $personLocationResidence->country_id = $this->residence_country_id;
        $personLocationResidence->country_unit_id = end($this->residence_city_ids);
        $personLocationResidence->street_id = $this->residence_street_id;
        $personLocationResidence->type = PersonLocationHelper::TYPE_RESIDENCE;

        $personLocationService->setLocation($person, $personLocationResidence);
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        if (Yii::$app instanceof Application && (
                Yii::$app->request->post(ActiveForm::$refreshParam)
                || Yii::$app->request->get(ActiveForm::$refreshParam)
            )
        ) {
            return false;
        }

        return parent::validate($attributeNames, $clearErrors);
    }
}
