<?php

namespace backend\models\forms;

use common\helpers\PersonCredentialHelper;
use common\models\person\Person;
use common\services\pds\PersonCredentialService;
use Yii;
use yii\base\Model;

class PersonForm extends Model
{
    public $id;
    public $nickname;
    public $firstname;
    public $lastname;
    public $middlename;
    public $sex;
    public $iin;
    public $nationality_id;
    public $type = 2;
    public $status;
    public $person_type;
    public $indentities;
    public $birth_date;
    public $institution_id;
    public $indentity;
    public $portal_uid;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'iin', 'person_type', 'birth_date', 'type', 'institution_id', 'status'], 'required'],

            [['status', 'sex', 'nationality_id', 'type', 'person_type'], 'default', 'value' => null],
            [['status', 'sex', 'nationality_id', 'type', 'id', 'institution_id', 'portal_uid'], 'integer'],

            [['birth_date'], 'safe'],
            [['nickname', 'firstname', 'lastname', 'middlename', 'iin', 'person_type', 'indentity'], 'string', 'max' => 100],
            ['iin', 'validateIIN'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'status' => Yii::t('app', 'Status'),
            'nickname' => Yii::t('app', 'Nickname'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'middlename' => Yii::t('app', 'Middlename'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'sex' => Yii::t('app', 'Sex'),
            'nationality_id' => Yii::t('app', 'Nationality ID'),
            'iin' => Yii::t('app', 'Iin'),
            'type' => Yii::t('app', 'Type'),
            'person_type' => Yii::t('app', 'Person Type'),
            'portal_uid' => Yii::t('app', 'PDS ID'),
            'indentity' => Yii::t('app', 'Логин'),
            'institution_id' => Yii::t('app', 'Колледж'),
        ];
    }

    /**
     * Validates the iin.
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateIIN($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $personExistsQuery = Person::find()
                ->where(['iin' => $this->iin]);
            if ($this->id !== null) {
                $personExistsQuery->andWhere(['!=', 'id', $this->id]);
            }

            if ($personExistsQuery->exists()) {
                $this->addError($attribute, $this->iin . ' уже занято');
            }
        }
    }
}
