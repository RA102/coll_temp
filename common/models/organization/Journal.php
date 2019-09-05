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
 * @property int $student_id
 * @property int $group_id
 * @property int $lesson_id
 * @property int $teacher_id
 * @property int $course_id
 * @property string $date
 * @property string $topic
 * @property int $mark
 *
 */
class Classroom extends \yii\db\ActiveRecord
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
            [['type', 'student_id', 'group_id', 'lesson_id', 'teacher_id', 'course_id', 'mark'], 'integer'],
            [['date', 'topic'], 'string'],
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
            'type' => Yii::t('app', 'Type ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'group_id' => Yii::t('app', 'Group ID'),
            'lesson_id' => Yii::t('app', 'Lesson ID'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'mark' => Yii::t('app', 'Mark'),
            'date' => Yii::t('app', 'Date'),
            'topic' => Yii::t('app', 'Topic'),
        ];
    }
}
