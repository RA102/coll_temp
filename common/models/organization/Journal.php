<?php

namespace common\models\organization;

use common\helpers\GroupHelper;
use common\helpers\LanguageHelper;
use common\models\handbook\Speciality;
use common\models\link\StudentGroupLink;
use common\models\person\Student;
use common\models\TeacherCourse;
use Yii;

/**
 * This is the model class for table "organization.journal".
 * 
 *
 * @property int $id
 * @property int $type
 * @property int $institution_id
 * @property int $group_id
 * @property int $teacher_id
 * @property int $teacher_course_id
 *
 */
class Journal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization.journal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'institution_id', 'group_id', 'teacher_id', 'teacher_course_id',], 'integer'],
            [['type'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'institution_id' => Yii::t('app', 'Institution ID'),
            'group_id' => Yii::t('app', 'Group ID'),
            'lesson_id' => Yii::t('app', 'Lesson ID'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'teacher_course_id' => Yii::t('app', 'Course ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherCourse()
    {
        return $this->hasOne(TeacherCourse::class, ['id' => 'teacher_course_id']);
    }
}
