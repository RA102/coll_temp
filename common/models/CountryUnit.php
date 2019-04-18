<?php

namespace common\models;

use common\models\organization\Institution;
use common\models\organization\InstitutionApplication;
use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "country_unit".
 *
 * @property int $id
 * @property int $oid
 * @property string $name
 * @property string $phone_code
 * @property int $country_id
 * @property int $parent_id
 * @property int $unit_type
 * @property string $caption
 * @property int $status
 * @property int $catf_code
 * @property string $kaz_post_id
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property Country $country
 * @property CountryUnit $parent
 * @property CountryUnit[] $children
 * @property Street[] $streets
 */
class CountryUnit extends \yii\db\ActiveRecord
{
    public $caption_current;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['oid', 'country_id', 'parent_id', 'unit_type', 'status', 'catf_code'], 'default', 'value' => null],
            [['oid', 'country_id', 'parent_id', 'unit_type', 'status', 'catf_code'], 'integer'],
            [['country_id'], 'required'],
            [['create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['name', 'caption'], 'string', 'max' => 255],
            [['phone_code'], 'string', 'max' => 40],
            [['kaz_post_id'], 'string', 'max' => 20],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['country_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryUnit::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'oid' => Yii::t('app', 'Oid'),
            'name' => Yii::t('app', 'Name'),
            'phone_code' => Yii::t('app', 'Phone Code'),
            'country_id' => Yii::t('app', 'Country ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'unit_type' => Yii::t('app', 'Unit Type'),
            'caption' => Yii::t('app', 'Caption'),
            'status' => Yii::t('app', 'Status'),
            'catf_code' => Yii::t('app', 'Catf Code'),
            'kaz_post_id' => Yii::t('app', 'Kaz Post ID'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id'])->inverseOf('countryUnits');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(CountryUnit::class, ['id' => 'parent_id'])->inverseOf('children');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(CountryUnit::class, ['parent_id' => 'id'])->inverseOf('parent');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStreets()
    {
        return $this->hasMany(Street::class, ['city_id' => 'id'])->inverseOf('city');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutions()
    {
        return $this->hasMany(Institution::class, ['city_id' => 'id'])->inverseOf('city');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionApplications()
    {
        return $this->hasMany(InstitutionApplication::class, ['city_id' => 'id'])->inverseOf('city');
    }

    public function afterFind()
    {
        $currentLanguage = \Yii::$app->language == 'kz-KZ' ? 'kk' : 'ru';
        $this->caption_current = Json::decode($this->getAttribute('caption'))[$currentLanguage];

        parent::afterFind();
    }
}
