<?php
namespace common\forms;

use common\models\organization\Institution;
use yii\base\Model;
use Yii;
use yii\web\Application;
use common\components\ActiveForm;

/**
 * InstitutionForm form
 */
class InstitutionForm extends Model
{
    public $email;
    public $educational_form_id;
    public $organizational_legal_form_id;
    public $name;
    public $description;
    public $city_id;
    public $type_id;
    public $phone;
    public $fax;
    public $bin;
    public $street_id;
    public $house_number;
    public $website;
    public $status;
    public $foundation_year;
    public $max_grade;
    public $min_grade;
    public $max_shift;
    public $enable_fraction;

    public $country_id;
    public $city_ids = [];
    public $type_ids = [];

    public $hasCountryUnit = false;
    public $hasStreet = false;
    public $hasHouseNumber = false;

    public $hasInstitutionType = false;

    public function __construct(
        Institution $institution,
        array $config = []
    )
    {
        $this->setAttributes($institution->attributes);
        $this->type_ids = $institution->getInstitutionTypeIds();
        $this->city_ids = $institution->getCityIds();

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            [
                [
                    'name', 'phone', 'house_number'
                ],
                'required'
            ],
            [['country_id', 'city_ids', 'street_id'], 'default', 'value' => null],
            [['country_id'], 'required'],
            [['country_id', 'city_ids', 'street_id', 'type_ids'], 'safe'],
            [[
                'status', 'email', 'fax', 'website', 'max_grade', 'min_grade', 'max_shift', 'description',
                'foundation_year', 'bin', 'enable_fraction', 'educational_form_id', 'organizational_legal_form_id'],
                'safe'],
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
            'country_id' => Yii::t('app', 'Address'),
            'street_id' => Yii::t('app', 'Street ID'),
            'max_shift' => Yii::t('app', 'Max Shift'),
            'max_grade' => Yii::t('app', 'Max Grade'),
            'min_grade' => Yii::t('app', 'Min Grade'),
            'foundation_year' => Yii::t('app', 'Foundation Year'),
            'fax' => Yii::t('app', 'Fax'),
            'website' => Yii::t('app', 'Website'),
            'enable_fraction' => Yii::t('app', 'Enable Fraction'),
            'bin' => Yii::t('app', 'Bin'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        if (Yii::$app instanceof Application && (
                Yii::$app->request->post(ActiveForm::$refreshParam)
                || Yii::$app->request->get(ActiveForm::$refreshParam)
            )
        ) {
            return false;
        }

        return parent::validate($attributeNames, $clearErrors);
    }
}
