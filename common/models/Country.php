<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property string $name
 * @property int $oid
 * @property string $caption
 * @property string $iso
 * @property int $status
 * @property string $currency_iso
 * @property string $phone_code
 * @property string $phone_number_mask
 * @property string $catf_mask
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 * @property int $sort
 *
 * @property CountryUnit[] $countryUnits
 */
class Country extends \yii\db\ActiveRecord
{
    public $caption_current;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['oid', 'status', 'sort'], 'default', 'value' => null],
            [['oid', 'status', 'sort'], 'integer'],
            [['iso'], 'required'],
            [['create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['name', 'caption'], 'string', 'max' => 255],
            [['iso', 'currency_iso'], 'string', 'max' => 3],
            [['phone_code'], 'string', 'max' => 10],
            [['phone_number_mask', 'catf_mask'], 'string', 'max' => 30],
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
            'oid' => Yii::t('app', 'Oid'),
            'caption' => Yii::t('app', 'Caption'),
            'iso' => Yii::t('app', 'Iso'),
            'status' => Yii::t('app', 'Status'),
            'currency_iso' => Yii::t('app', 'Currency Iso'),
            'phone_code' => Yii::t('app', 'Phone Code'),
            'phone_number_mask' => Yii::t('app', 'Phone Number Mask'),
            'catf_mask' => Yii::t('app', 'Catf Mask'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryUnits()
    {
        return $this->hasMany(CountryUnit::class, ['country_id' => 'id'])->inverseOf('country');
    }

    public function afterFind()
    {
        $currentLanguage = \Yii::$app->language == 'kz-KZ' ? 'kk' : 'ru';
        $this->caption_current = Json::decode($this->getAttribute('caption'))[$currentLanguage];

        parent::afterFind();
    }
}
