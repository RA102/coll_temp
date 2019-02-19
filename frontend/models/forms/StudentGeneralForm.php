<?php

namespace frontend\models\forms;

use common\models\person\Person;
use common\services\pds\PersonCredential;
use Yii;
use yii\base\Model;

class StudentGeneralForm extends Model
{
    public $firstname;
    public $lastname;
    public $middlename;
    public $birth_date;
    public $birth_place;
    public $sex;
    public $iin;
    public $nationality_id;
    public $language;

    public $generate_credential = false;
    public $credential_type = PersonCredential::TYPE_EMAIL;
    public $indentity;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            'fullNameString' => [['firstname', 'lastname', 'middlename'], 'string', 'max' => 100],
            'fullNameRequired' => [['firstname', 'lastname'], 'required'],
            'birthDateRequired' => [['birth_date'], 'required'],
            'birthPlaceString' => [['birth_place'], 'string', 'max' => 255],
            'sexValidation' => [['sex'], 'in', 'range' => [Person::SEX_NONE, Person::SEX_MALE, Person::SEX_FEMALE]],
            'iinString' => [['iin'], 'string', 'min' => 12, 'max' => 12],

            ['generate_credential', 'boolean'],
            ['generate_credential', 'default', 'value' => false],
            ['indentity', 'email', 'skipOnEmpty' => true],

            ['nationality_id', 'required'], // TODO foreign key check
            ['language', 'required'],
            ['language', 'string', 'min' => 2, 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'middlename' => Yii::t('app', 'Middlename'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'birth_place' => Yii::t('app', 'Birth Place'),
            'sex' => Yii::t('app', 'Sex'),
            'nationality_id' => Yii::t('app', 'Nationality ID'),
            'iin' => Yii::t('app', 'Iin'),
            'language' => Yii::t('app', 'Language'),
            'generate_credential' => Yii::t('app', 'Create a user?'),
            'indentity' => Yii::t('app', 'Email'),
        ];
    }
}
