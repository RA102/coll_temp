<?php

namespace common\models\person;

use common\helpers\SchemeHelper;
use common\models\Country;
use common\models\CountryUnit;
use common\models\Street;
use Yii;

/**
 * This is the model class for table "person.person_location".
 *
 * @property int $id
 * @property int $person_id
 * @property int $country_id
 * @property int $country_unit_id
 * @property int $street_id
 * @property int $status
 * @property int $type
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property Person $person
 * @property Country $country
 * @property CountryUnit $countryUnit
 * @property Street $street
 */
class PersonLocation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PERSON . 'person_location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_id', 'country_id'], 'required'],
            [['person_id', 'country_id', 'country_unit_id', 'street_id', 'status', 'type'], 'default', 'value' => null],
            [['person_id', 'country_id', 'country_unit_id', 'street_id', 'status', 'type'], 'integer'],
            [['create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::class, 'targetAttribute' => ['person_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['country_id' => 'id']],
            [['country_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryUnit::class, 'targetAttribute' => ['country_unit_id' => 'id']],
            [['street_id'], 'exist', 'skipOnError' => true, 'targetClass' => Street::class, 'targetAttribute' => ['street_id' => 'id']],
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
            'country_id' => Yii::t('app', 'Country ID'),
            'country_unit_id' => Yii::t('app', 'Country Unit ID'),
            'street_id' => Yii::t('app', 'Street ID'),
            'status' => Yii::t('app', 'Status'),
            'type' => Yii::t('app', 'Type'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }

    public function getPerson()
    {
        return $this->hasOne(Person::class, ['id' => 'person_id']);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    public function getCountryUnit()
    {
        return $this->hasOne(CountryUnit::class, ['id' => 'country_unit_id']);
    }

    public function getCountryUnitIds()
    {
        $ids = [];
        $item = $this->countryUnit;
        while ($item != null) {
            $ids[] = $item->id;

            $item = $item->parent;
        }

        return array_reverse($ids);
    }

    public function getStreet()
    {
        return $this->hasOne(Street::class, ['id' => 'street_id']);
    }

    public static function add(Person $person, Country $country, CountryUnit $countryUnit, Street $street, $type, $status = 1): PersonLocation
    {
        $model = new static();
        $model->person_id = $person->id;
        $model->country_id = $country->id;
        $model->country_unit_id = $countryUnit->id;
        $model->street_id = $street->id;
        $model->type = $type;
        $model->status = $status;

        return $model;
    }
}
