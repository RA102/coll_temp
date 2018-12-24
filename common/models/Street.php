<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "street".
 *
 * @property int $id
 * @property string $caption
 * @property int $city_id
 * @property int $type_id
 * @property int $region_city_oid
 * @property int $oid
 * @property int $server_id
 * @property string $kaz_post_id
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property CountryUnit $city
 */
class Street extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'street';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'type_id'], 'required'],
            [['city_id', 'type_id', 'region_city_oid', 'oid', 'server_id'], 'default', 'value' => null],
            [['city_id', 'type_id', 'region_city_oid', 'oid', 'server_id'], 'integer'],
            [['create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['caption'], 'string', 'max' => 255],
            [['kaz_post_id'], 'string', 'max' => 20],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryUnit::class, 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'caption' => Yii::t('app', 'Caption'),
            'city_id' => Yii::t('app', 'City ID'),
            'type_id' => Yii::t('app', 'Type ID'),
            'region_city_oid' => Yii::t('app', 'Region City Oid'),
            'oid' => Yii::t('app', 'Oid'),
            'server_id' => Yii::t('app', 'Server ID'),
            'kaz_post_id' => Yii::t('app', 'Kaz Post ID'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(CountryUnit::class, ['id' => 'city_id'])->inverseOf('streets');
    }
}
