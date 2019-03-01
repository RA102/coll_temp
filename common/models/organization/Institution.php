<?php

namespace common\models\organization;

use common\helpers\SchemeHelper;
use common\models\Course;
use common\models\handbook\Speciality;
use common\models\link\PersonInstitutionLink;
use common\models\person\Person;
use Yii;
use yii\db\ActiveQuery;

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
 *
 * @property Speciality[] $specialities
 * @property InstitutionSpecialityInfo[] $specialityInfos
 * @property InstitutionDiscipline[] $institutionDisciplines
 * @property PersonInstitutionLink[] $personInstitutionLinks
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
            'name' => Yii::t('app', 'Title'),
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
            'max_shift' => Yii::t('app', 'Max Shift'),
            'max_grade' => Yii::t('app', 'Max Grade'),
            'min_grade' => Yii::t('app', 'Min Grade'),
            'enable_fraction' => Yii::t('app', 'Enable Fraction'),
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

    public static function add(
        $street_id,
        $city_id,
        $type_id,
        $house_number,
        $educational_form_id,
        $organizational_legal_form_id
    ) {
        $model = new Institution();
        $model->street_id = $street_id;
        $model->city_id = $city_id;
        $model->type_id = $type_id;
        $model->house_number = $house_number;
        $model->educational_form_id = $educational_form_id;
        $model->organizational_legal_form_id = $organizational_legal_form_id;

        return $model;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialities()
    {
        return $this->hasMany(Speciality::className(), ['id' => 'speciality_id'])
            ->viaTable('organization.institution_speciality_info', ['institution_id' => 'id'],
                function (ActiveQuery $query){
                    $query->andWhere('organization.institution_speciality_info.is_deleted is not true');
                });
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialityInfos()
    {
        return $this->hasMany(InstitutionSpecialityInfo::className(), ['institution_id' => 'id'])
            ->andWhere('organization.institution_speciality_info.is_deleted is not true');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionDisciplines()
    {
        return $this->hasMany(InstitutionDiscipline::class, ['institution_id' => 'id'])->inverseOf('institution');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonInstitutionLinks()
    {
        return $this->hasMany(PersonInstitutionLink::class, ['institution_id' => 'id']);
    }

    public function getYearList()
    {
        $years = [];
        for ($i = 1; $i <= $this->max_grade; $i++) {
            $years[$i] = $i;
        }

        return $years;
    }
}
