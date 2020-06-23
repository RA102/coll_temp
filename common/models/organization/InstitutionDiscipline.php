<?php

namespace common\models\organization;

use common\helpers\SchemeHelper;
use common\models\Discipline;
use common\models\person\Employee;
use Yii;
use yii\db\ArrayExpression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "organization.institution_discipline".
 *
 * @property int $id
 * @property int $institution_id
 * @property array $caption
 * @property string $slug
 * @property int[] $types
 * @property int $status
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 * @property int[] $teachers
 * @property int $department_id
 *
 * @property Institution $institution
 * @property Discipline $discipline
 */
class InstitutionDiscipline extends \yii\db\ActiveRecord
{
    const TYPE_STANDARD = 1; // эталонный
    const TYPE_OPTIONAL = 2; // необязательный
    const TYPE_ELECTIVE = 3; // факультатив
    const TYPE_ENT = 4; // предметы для ент
    const TYPE_EXAM = 5; // экзаменационные

    public $caption_current;
    public $caption_ru;
    public $caption_kk;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::ORGANIZATION . 'institution_discipline';
    }

    public function afterFind()
    {
        parent::afterFind();

        if ($this->types instanceof ArrayExpression) {
            $this->types = $this->types->getValue();
        }

        if ($this->teachers instanceof ArrayExpression) {
            $this->teachers = $this->teachers->getValue();
        }

        $currentLanguage = \Yii::$app->language == 'kz-KZ' ? 'kk' : 'ru';
        $this->caption_current = $this->caption[$currentLanguage] ?? $this->caption['ru'];
        $this->caption_ru = $this->caption['ru'];
        $this->caption_kk = $this->caption['kk'];
    }

    public function beforeSave($insert)
    {
        $this->caption = [
            'ru' => $this->caption_ru,
            'kk' => $this->caption_kk,
        ];

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['institution_id'], 'required'],
            [['institution_id', 'status'], 'default', 'value' => null],
            [['department_id'], 'default', 'value' => []],
            [['teachers'], 'default', 'value' => []],
            [['types'], 'default', 'value' => []],
            [['institution_id', 'status'], 'integer'],
            [['department_id'], 'each', 'rule' => ['integer']],
            [['teachers'], 'each', 'rule' => ['integer']],
            [['types'], 'each', 'rule' => ['integer']],
            [['institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => Institution::class, 'targetAttribute' => ['institution_id' => 'id']],
            [['slug'], 'string', 'max' => 255],
            [['caption_ru', 'caption_kk'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'institution_id' => Yii::t('app', 'Institution ID'),
            'caption' => Yii::t('app', 'Caption'),
            'caption_ru' => Yii::t('app', 'Caption Ru'),
            'caption_kk' => Yii::t('app', 'Caption Kk'),
            'caption_current' => Yii::t('app', 'Caption Current'),
            'slug' => Yii::t('app', 'Slug'),
            'types' => Yii::t('app', 'Discipline Type'),
            'status' => Yii::t('app', 'Status'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
            'teachers' => Yii::t('app', 'Teachers'),
            'department_id' => Yii::t('app', 'Department'),
            'department.caption_current' => Yii::t('app', 'Department'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitution()
    {
        return $this->hasOne(Institution::class, ['id' => 'institution_id']);
    }

    /**
     * @deprecated
     * @return \yii\db\ActiveQuery
     */
    public function getTeachers()
    {
        return Employee::find()->where(['id' => $this->teachers])->all();
    }

    public function getDepartment()
    {
        return $this->hasOne(InstitutionDepartment::class, ['id' => 'department_id']);
    }

    public function saveDepartment($department_id)
    {
        $department = InstitutionDepartment::findOne($department_id);

        if($department != null) {
            $this->link('department', $department);
            return true;
        }
    }
}
