<?php

namespace frontend\models\forms;

use common\helpers\PersonInfoHelper;
use common\models\person\Person;
use common\services\person\PersonInfoService;
use yii\base\Model;

class PersonDocumentsForm extends Model
{
    public $identity_card_number;
    public $identity_card_issued_date;
    public $identity_card_valid_date;
    public $identity_card_issued;

    public $passport_series;
    public $passport_number;
    public $passport_issued_date;
    public $passport_valid_date;
    public $passport_issued;

    public function __construct(Person $person, PersonInfoService $personInfoService, array $config = [])
    {
        $this->identity_card_number = $personInfoService->getInfoValue($person, PersonInfoHelper::IDENTITY_CARD_NUMBER);
        $this->identity_card_issued_date = $personInfoService->getInfoValue($person, PersonInfoHelper::IDENTITY_CARD_ISSUED_DATE);
        $this->identity_card_valid_date = $personInfoService->getInfoValue($person, PersonInfoHelper::IDENTITY_CARD_VALID_DATE);
        $this->identity_card_issued = $personInfoService->getInfoValue($person, PersonInfoHelper::IDENTITY_CARD_ISSUED);

        $this->passport_series = $personInfoService->getInfoValue($person, PersonInfoHelper::PASSPORT_SERIES);
        $this->passport_number = $personInfoService->getInfoValue($person, PersonInfoHelper::PASSPORT_NUMBER);
        $this->passport_issued_date = $personInfoService->getInfoValue($person, PersonInfoHelper::PASSPORT_ISSUED_DATE);
        $this->passport_valid_date = $personInfoService->getInfoValue($person, PersonInfoHelper::PASSPORT_VALID_DATE);
        $this->passport_issued = $personInfoService->getInfoValue($person, PersonInfoHelper::PASSPORT_ISSUED);

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
            [['identity_card_issued'], 'string'],

            [['passport_series'], 'string'],
            [['passport_number'], 'string'],
            [['passport_issued_date'], 'string'],
            [['passport_valid_date'], 'string'],
            [['passport_issued'], 'string'],
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
            'identity_card_issued' => 'Кем выдано',

            'passport_series' => 'Серия',
            'passport_number' => 'Номер паспорта',
            'passport_issued_date' => 'Дата выдачи',
            'passport_valid_date' => 'Действителен до',
            'passport_issued' => 'Кем выдан',
        ];
    }

    public function apply(Person $person, PersonInfoService $personInfoService)
    {
        $personInfoService->setInfoValue($person, PersonInfoHelper::IDENTITY_CARD_NUMBER, $this->identity_card_number);
        $personInfoService->setInfoValue($person, PersonInfoHelper::IDENTITY_CARD_ISSUED_DATE, $this->identity_card_issued_date);
        $personInfoService->setInfoValue($person, PersonInfoHelper::IDENTITY_CARD_VALID_DATE, $this->identity_card_valid_date);
        $personInfoService->setInfoValue($person, PersonInfoHelper::IDENTITY_CARD_ISSUED, $this->identity_card_issued);

        $personInfoService->setInfoValue($person, PersonInfoHelper::PASSPORT_SERIES, $this->passport_series);
        $personInfoService->setInfoValue($person, PersonInfoHelper::PASSPORT_NUMBER, $this->passport_number);
        $personInfoService->setInfoValue($person, PersonInfoHelper::PASSPORT_ISSUED_DATE, $this->passport_issued_date);
        $personInfoService->setInfoValue($person, PersonInfoHelper::PASSPORT_VALID_DATE, $this->passport_valid_date);
        $personInfoService->setInfoValue($person, PersonInfoHelper::PASSPORT_ISSUED, $this->passport_issued);
    }
}
