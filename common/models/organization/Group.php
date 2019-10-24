<?php

namespace common\models\organization;

use common\helpers\GroupHelper;
use common\helpers\LanguageHelper;
use common\models\handbook\Speciality;
use common\models\link\StudentGroupLink;
use common\models\person\Student;
use common\models\OptionalDisciplines;
use common\models\RequiredDisciplines;
use common\models\TeacherCourse;
use Yii;

/**
 * This is the model class for table "organization.group".
 * Group is an entity for college group of students
 *
 * @property int $id
 * @property array $caption
 * @property string $language
 * @property int $speciality_id
 * @property int $max_class
 * @property int $class
 * @property int $education_form
 * @property int $education_pay_form
 * @property int $institution_id
 * @property int $parent_id
 * @property int $type
 * @property int $rating_system_id
 * @property int $based_classes
 * @property array $class_change_history
 * @property array $properties
 * @property bool $is_deleted
 * @property string $start_ts
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property Speciality $speciality
 * @property TeacherCourse[] $teacherCourses
 * @property StudentGroupLink[] $studentGroupLinks
 * @property Student[] $students
 */
class Group extends \yii\db\ActiveRecord
{
    const EDUCATION_FORM_FULL_TIME = 1;
    const EDUCATION_FORM_CORRESPONDENCE = 2;
    const EDUCATION_FORM_EVENING = 3;

    const EDUCATION_PAY_FORM_BUDGET = 1;
    const EDUCATION_PAY_FORM_CONTRACT = 2;
    const EDUCATION_PAY_FORM_MIXED = 3;

    // name of group in current locale
    public $caption_current;

    public $caption_ru;
    public $caption_kk;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization.group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caption', 'class_change_history', 'properties', 'start_ts', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['speciality_id', 'max_class', 'class', 'education_form', 'education_pay_form', 'institution_id', 'parent_id', 'type', 'rating_system_id', 'based_classes'], 'default', 'value' => null],
            [['speciality_id', 'max_class', 'class', 'education_form', 'education_pay_form', 'institution_id', 'parent_id', 'type', 'rating_system_id', 'based_classes'], 'integer'],
            [['is_deleted'], 'boolean'],
            [['language'], 'string', 'max' => 2],
            [['speciality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Speciality::className(), 'targetAttribute' => ['speciality_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => Institution::className(), 'targetAttribute' => ['institution_id' => 'id']],
            [['caption_ru', 'caption_kk', 'speciality_id', 'education_form', 'education_pay_form', 'max_class', 'class', 'language'], 'required'],
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
            'caption_ru' => Yii::t('app', 'Caption Ru'),
            'caption_kk' => Yii::t('app', 'Caption Kk'),
            'caption_current' => Yii::t('app', 'Caption Current'),
            'language' => Yii::t('app', 'Language'),
            'speciality_id' => Yii::t('app', 'Speciality ID'),
            'max_class' => Yii::t('app', 'Max Class'),
            'class' => Yii::t('app', 'Class'),
            'education_form' => Yii::t('app', 'Education Form'),
            'education_pay_form' => Yii::t('app', 'Education Pay Form'),
            'institution_id' => Yii::t('app', 'Institution ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'type' => Yii::t('app', 'Type'),
            'rating_system_id' => Yii::t('app', 'Rating System ID'),
            'based_classes' => Yii::t('app', 'Based Classes'),
            'class_change_history' => Yii::t('app', 'Class Change History'),
            'properties' => Yii::t('app', 'Properties'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'start_ts' => Yii::t('app', 'Start Ts'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }

    public function beforeSave($insert)
    {
        // set json caption from two non json fields
        $this->caption = [
            'ru' => $this->caption_ru,
            'kk' => $this->caption_kk,
        ];

        return parent::beforeSave($insert);
    }

    public static function find()
    {
        // some group were moved from old project
        // that project had two types of groups: studying process and reception commission
        // in this project  groups for studying process "Group" and for reception commission "ReceptionGroup"
        return parent::find()->andWhere([
            'OR',
            ['organization.group.type' => 1], // type "studying process", from study.bilimal.kz
            ['organization.group.type' => null] // groups created in college.bilimal.kz
        ]);
    }

    public function afterFind()
    {
        $currentLanguage = \Yii::$app->language == 'kz-KZ' ? 'kk' : 'ru';
        // set current caption, can be used as default caption variant
        $this->caption_current = $this->caption[$currentLanguage] ?? $this->caption['ru'] ?? $this->caption['kk'] ?? null;
        // set caption in russian and kazakh
        $this->caption_ru = $this->caption['ru'] ?? null;
        $this->caption_kk = $this->caption['kk'] ?? null;

        parent::afterFind();
    }

    public function getSpeciality()
    {
        return $this->hasOne(Speciality::class, ['id' => 'speciality_id']);
    }

    public function getInstitution()
    {
        return $this->hasOne(Institution::class, ['id' => 'institution_id']);
    }

    public function getEducationForm()
    {
        return GroupHelper::getEducationFormList()[$this->education_form] ?? '';
    }

    public function getEducationPayForm()
    {
        return GroupHelper::getEducationPayFormList()[$this->education_pay_form] ?? '';
    }

    public function getLanguage()
    {
        return LanguageHelper::getLanguageList()[$this->language] ?? '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherCourses()
    {
        return $this->hasMany(TeacherCourse::class, ['id' => 'teacher_course_id'])
            ->viaTable('link.teacher_course_group_link', ['group_id' => 'id']);
    }

    public function getRequiredDisciplines()
    {
        return $this->hasMany(RequiredDisciplines::class, ['group_id' => 'id']);
    }

    public function getOptionalDisciplines()
    {
        //$sql = "SELECT * FROM ".OptionalDisciplines::tableName()." WHERE groups IN [".$this->id."]";
        return OptionalDisciplines::find()->where(['IN', 'groups', $this->id])->asArray()->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentGroupLinks()
    {
        return $this->hasMany(StudentGroupLink::class, ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::class, ['id' => 'student_id'])
            ->via('studentGroupLinks')->orderBy(['lastname' => SORT_ASC]);
    }
}
