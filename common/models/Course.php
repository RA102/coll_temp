<?php

namespace common\models;

use common\helpers\SchemeHelper;
use common\models\organization\InstitutionDiscipline;
use Yii;
use yii\db\ArrayExpression;

/**
 * This is the model class for table "course".
 *
 * @property int $id
 * @property array $caption
 * @property int[] $classes
 * @property int $status
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property InstitutionDiscipline $institutionDiscipline
 * @property TeacherCourse[] $teacherCourses
 */
class Course extends \yii\db\ActiveRecord
{
    public $caption_current;
    public $caption_ru;
    public $caption_kk;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PUBLIC . 'course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['institution_discipline_id'], 'required'],
            [['status'], 'default', 'value' => null],
            [['institution_discipline_id', 'status'], 'integer'],
            [['classes'], 'each', 'rule' => ['integer']],
            [['caption_ru', 'caption_kk'], 'string'],
            [['institution_discipline_id'], 'exist', 'skipOnError' => true, 'targetClass' => InstitutionDiscipline::class, 'targetAttribute' => ['institution_discipline_id' => 'id']],
        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        if ($this->classes instanceof ArrayExpression) {
            $this->classes = $this->classes->getValue();
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
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'institution_discipline_id' => Yii::t('app', 'Institution Discipline ID'),
            'caption' => Yii::t('app', 'Caption'),
            'caption_ru' => Yii::t('app', 'Caption Ru'),
            'caption_kk' => Yii::t('app', 'Caption Kk'),
            'caption_current' => Yii::t('app', 'Caption Current'),
            'classes' => Yii::t('app', 'Classes'),
            'status' => Yii::t('app', 'Status'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionDiscipline()
    {
        return $this->hasOne(InstitutionDiscipline::class, ['id' => 'institution_discipline_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherCourses()
    {
        return $this->hasMany(TeacherCourse::class, ['course_id' => 'id'])->inverseOf('course');
    }
}
