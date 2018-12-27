<?php

namespace common\models\organization;

use Yii;

/**
 * This is the model class for table "organization.institution_application".
 *
 * @property int $id
 * @property string $iin
 * @property int $sex
 * @property string $email
 * @property string $phone
 * @property string $name
 * @property int $city_id
 * @property int $type_id
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * @property string $street
 * @property string $birth_date
 * @property string $house_number
 * @property int $educational_form_id
 * @property int $organizational_legal_form_id
 * @property int $status
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 */
class InstitutionApplication extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization.institution_application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sex', 'city_id', 'type_id', 'educational_form_id', 'organizational_legal_form_id', 'status'], 'default', 'value' => null],
            [['sex', 'city_id', 'type_id', 'educational_form_id', 'organizational_legal_form_id', 'status'], 'integer'],
            [['birth_date', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['iin', 'house_number'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['name', 'street'], 'string', 'max' => 511],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'iin' => Yii::t('app', 'Iin'),
            'sex' => Yii::t('app', 'Sex'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'name' => Yii::t('app', 'Title'),
            'city_id' => Yii::t('app', 'City ID'),
            'type_id' => Yii::t('app', 'Type ID'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'middlename' => Yii::t('app', 'Middlename'),
            'street' => Yii::t('app', 'Street'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'house_number' => Yii::t('app', 'House Number'),
            'educational_form_id' => Yii::t('app', 'Educational Form ID'),
            'organizational_legal_form_id' => Yii::t('app', 'Organizational Legal Form ID'),
            'status' => Yii::t('app', 'Status'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }

    public function isNew()
    {
        return $this->status == self::STATUS_NEW;
    }
}
