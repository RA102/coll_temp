<?php

namespace frontend\models\forms;

use common\helpers\PersonInfoHelper;
use common\models\person\Person;
use Yii;
use yii\base\Model;

class PersonDocumentsForm extends Model
{
    public $identity_card_number;
    public $identity_card_issued_date;
    public $identity_card_valid_date;

    public $passport_series;
    public $passport_number;
    public $passport_issued_date;
    public $passport_valid_date;

    public function __construct(Person $person, array $config = [])
    {
        $this->identity_card_number = $person->getPersonInfoValue(PersonInfoHelper::IDENTITY_CARD_NUMBER);
        $this->identity_card_issued_date = $person->getPersonInfoValue(PersonInfoHelper::IDENTITY_CARD_ISSUED_DATE);
        $this->identity_card_valid_date = $person->getPersonInfoValue(PersonInfoHelper::IDENTITY_CARD_VALID_DATE);

        $this->passport_series = $person->getPersonInfoValue(PersonInfoHelper::PASSPORT_SERIES);
        $this->passport_number = $person->getPersonInfoValue(PersonInfoHelper::PASSPORT_NUMBER);
        $this->passport_issued_date = $person->getPersonInfoValue(PersonInfoHelper::PASSPORT_ISSUED_DATE);
        $this->passport_valid_date = $person->getPersonInfoValue(PersonInfoHelper::PASSPORT_VALID_DATE);

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['identity_card_number'], 'string'],
            [['identity_card_issued_date'], 'string'],
            [['identity_card_valid_date'], 'string'],

            [['passport_series'], 'string'],
            [['passport_number'], 'string'],
            [['passport_issued_date'], 'string'],
            [['passport_valid_date'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'identity_card_number' => 'Номер удостоверения личности',
            'identity_card_issued_date' => 'Дата выдачи',
            'identity_card_valid_date' => 'Действительно до',

            'passport_series' => 'Серия',
            'passport_number' => 'Номер паспорта',
            'passport_issued_date' => 'Дата выдачи',
            'passport_valid_date' => 'Действителен до',
        ];
    }

    public function apply(Person $person)
    {
        $person->setPersonInfoValue(PersonInfoHelper::IDENTITY_CARD_NUMBER, $this->identity_card_number);
        $person->setPersonInfoValue(PersonInfoHelper::IDENTITY_CARD_ISSUED_DATE, $this->identity_card_issued_date);
        $person->setPersonInfoValue(PersonInfoHelper::IDENTITY_CARD_VALID_DATE, $this->identity_card_valid_date);

        $person->setPersonInfoValue(PersonInfoHelper::PASSPORT_SERIES, $this->passport_series);
        $person->setPersonInfoValue(PersonInfoHelper::PASSPORT_NUMBER, $this->passport_number);
        $person->setPersonInfoValue(PersonInfoHelper::PASSPORT_ISSUED_DATE, $this->passport_issued_date);
        $person->setPersonInfoValue(PersonInfoHelper::PASSPORT_VALID_DATE, $this->passport_valid_date);
    }
}
