<?php

namespace common\models;

use common\models\person\Person;
use Yii;

/**
 * This is the model class for table "person.person_relative".
 *
 * @property int $id
 * @property int $person_id
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * @property string $birth_date
 * @property int $residence_city_id
 * @property string $residence_address
 * @property string $iin
 * @property int $relation_type
 * @property int $status
 * @property string $home_phone
 * @property string $mobile_phone
 * @property string $email
 * @property int $guardian_document_type
 * @property string $guardian_document_number
 * @property string $guardian_document_issued_date
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 */
class PersonRelative extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person.person_relative';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_id'], 'required'],
            [['person_id', 'residence_city_id', 'relation_type', 'status', 'guardian_document_type'], 'default', 'value' => null],
            [['person_id', 'residence_city_id', 'relation_type', 'status', 'guardian_document_type'], 'integer'],
            [['birth_date', 'guardian_document_issued_date', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['firstname', 'lastname', 'middlename', 'email', 'guardian_document_number'], 'string', 'max' => 100],
            [['residence_address'], 'string', 'max' => 511],
            [['iin'], 'string', 'max' => 12],
            [['home_phone', 'mobile_phone'], 'string', 'max' => 20],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['person_id' => 'id']],
            [['residence_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryUnit::className(), 'targetAttribute' => ['residence_city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'person_id' => Yii::t('app', 'Person ID'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'middlename' => Yii::t('app', 'Middlename'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'residence_city_id' => Yii::t('app', 'Residence City ID'),
            'residence_address' => Yii::t('app', 'Residence Address'),
            'iin' => Yii::t('app', 'Iin'),
            'relation_type' => Yii::t('app', 'Relation Type'),
            'status' => Yii::t('app', 'Status'),
            'home_phone' => Yii::t('app', 'Home Phone'),
            'mobile_phone' => Yii::t('app', 'Mobile Phone'),
            'email' => Yii::t('app', 'Email'),
            'guardian_document_type' => Yii::t('app', 'Guardian Document Type'),
            'guardian_document_number' => Yii::t('app', 'Guardian Document Number'),
            'guardian_document_issued_date' => Yii::t('app', 'Guardian Document Issued Date'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }
}
