<?php

namespace frontend\models\forms;

use common\helpers\PersonContactHelper;
use common\models\person\Person;
use common\services\person\PersonContactService;
use yii\base\Model;

class PersonContactsForm extends Model
{
    public $contact_phone_home;
    public $contact_phone_mobile;

    public function __construct(Person $person, PersonContactService $personContactService, array $config = [])
    {
        $this->contact_phone_home = $personContactService->getContactValue($person, PersonContactHelper::PHONE_HOME);
        $this->contact_phone_mobile = $personContactService->getContactValue($person, PersonContactHelper::PHONE_MOBILE);

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

    public function apply(Person $person, PersonContactService $personContactService)
    {
        $personContactService->setContactValue($person, PersonContactHelper::PHONE_HOME, $this->contact_phone_home);
        $personContactService->setContactValue($person, PersonContactHelper::PHONE_MOBILE, $this->contact_phone_mobile);
    }
}
