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

    public $residence_country_id;
    public $residence_city_ids = [];
    public $residence_street_id;


    public $hasCountryUnit = false;
    public $hasStreet = false;

    public function __construct(
        Person $person,
        PersonContactService $personContactService,
        PersonLocationService $personLocationService,
        array $config = [])
    {
        $this->contact_phone_home = $personContactService->getContactValue($person, PersonContactHelper::PHONE_HOME);
        $this->contact_phone_mobile = $personContactService->getContactValue($person, PersonContactHelper::PHONE_MOBILE);

        $personLocation = $personLocationService->getLocation($person, PersonLocationHelper::TYPE_REGISTRATION);
        if ($personLocation) {
            $this->residence_country_id = $personLocation->country_id;
            $this->residence_city_ids = $personLocation->getCountryUnitIds();
            $this->residence_street_id = $personLocation->street_id;
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
            [['residence_country_id', 'residence_city_ids', 'residence_street_id'], 'default', 'value' => null],
            [['residence_country_id'], 'required'],
            [['residence_country_id', 'residence_city_ids', 'residence_street_id'], 'safe'],
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
        ];
    }

    public function apply(Person $person, PersonContactService $personContactService, PersonLocationService $personLocationService)
    {
        $personContactService->setContactValue($person, PersonContactHelper::PHONE_HOME, $this->contact_phone_home);
        $personContactService->setContactValue($person, PersonContactHelper::PHONE_MOBILE, $this->contact_phone_mobile);

        $personLocation = $personLocationService->getLocation($person, PersonLocationHelper::TYPE_REGISTRATION);
        if (!$personLocation) {
            $personLocation = new PersonLocation();
        }
        $personLocation->country_id = $this->residence_country_id;
        $personLocation->country_unit_id = end($this->residence_city_ids);
        $personLocation->street_id = $this->residence_street_id;
        $personLocation->type = PersonLocationHelper::TYPE_REGISTRATION;

        $personLocationService->setLocation($person, $personLocation);
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
