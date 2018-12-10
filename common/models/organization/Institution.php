<?php

namespace common\models\organization;

use common\helpers\SchemeHelper;
use Yii;

/**
 * This is the model class for table "organization.institution".
 *
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property int $city_id
 * @property int $parent_id
 * @property int $type_id
 * @property int $educational_form_id
 * @property int $organizational_legal_form_id
 * @property int $oid
 * @property int $server_id
 * @property int $street_id
 * @property string $house_number
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $languages_iso
 * @property string $description
 * @property string $bin
 * @property int $foundation_year
 * @property string $website
 * @property int $max_grade
 * @property string $info
 * @property string $domain
 * @property string $db_name
 * @property string $db_user
 * @property string $db_password
 * @property bool $initialization
 * @property int $status
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 */
class Institution extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::ORGANIZATION . 'institution';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_id', 'city_id', 'parent_id', 'type_id', 'educational_form_id', 'organizational_legal_form_id', 'oid', 'server_id', 'street_id', 'foundation_year', 'max_grade', 'status'], 'default', 'value' => null],
            [['country_id', 'city_id', 'parent_id', 'type_id', 'educational_form_id', 'organizational_legal_form_id', 'oid', 'server_id', 'street_id', 'foundation_year', 'max_grade', 'status'], 'integer'],
            [['description', 'info'], 'string'],
            [['initialization'], 'boolean'],
            [['create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['name'], 'string', 'max' => 511],
            [['house_number', 'email', 'domain', 'db_name', 'db_user', 'db_password'], 'string', 'max' => 255],
            [['phone', 'fax'], 'string', 'max' => 20],
            [['languages_iso'], 'string', 'max' => 2],
            [['bin', 'website'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'country_id' => Yii::t('app', 'Country ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'type_id' => Yii::t('app', 'Type ID'),
            'educational_form_id' => Yii::t('app', 'Educational Form ID'),
            'organizational_legal_form_id' => Yii::t('app', 'Organizational Legal Form ID'),
            'oid' => Yii::t('app', 'Oid'),
            'server_id' => Yii::t('app', 'Server ID'),
            'street_id' => Yii::t('app', 'Street ID'),
            'house_number' => Yii::t('app', 'House Number'),
            'phone' => Yii::t('app', 'Phone'),
            'fax' => Yii::t('app', 'Fax'),
            'email' => Yii::t('app', 'Email'),
            'languages_iso' => Yii::t('app', 'Languages Iso'),
            'description' => Yii::t('app', 'Description'),
            'bin' => Yii::t('app', 'Bin'),
            'foundation_year' => Yii::t('app', 'Foundation Year'),
            'website' => Yii::t('app', 'Website'),
            'max_grade' => Yii::t('app', 'Max Grade'),
            'info' => Yii::t('app', 'Info'),
            'domain' => Yii::t('app', 'Domain'),
            'db_name' => Yii::t('app', 'Db Name'),
            'db_user' => Yii::t('app', 'Db User'),
            'db_password' => Yii::t('app', 'Db Password'),
            'initialization' => Yii::t('app', 'Initialization'),
            'status' => Yii::t('app', 'Status'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }
}
