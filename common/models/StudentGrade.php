<?php

namespace common\models;

use common\models\person\Student;
use Yii;

/**
 * This is the model class for table "student_grade".
 *
 * @property int $id
 * @property int $student_id
 * @property int $type
 * @property int $value
 * @property int $course_id
 * @property int $lesson_id
 * @property int $foreign_id
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property Student $student
 * @property Course $course
 * @property Lesson $lesson
 */
class StudentGrade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_grade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id'], 'required'],
            [['student_id', 'type', 'value', 'course_id', 'lesson_id', 'foreign_id'], 'default', 'value' => null],
            [['student_id', 'type', 'value', 'course_id', 'lesson_id', 'foreign_id'], 'integer'],
            [['create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::class, 'targetAttribute' => ['student_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['course_id' => 'id']],
            [['lesson_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lesson::class, 'targetAttribute' => ['lesson_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student ID',
            'type' => 'Type',
            'value' => 'Value',
            'course_id' => 'Course ID',
            'lesson_id' => 'Lesson ID',
            'foreign_id' => 'Foreign ID',
            'create_ts' => 'Create Ts',
            'update_ts' => 'Update Ts',
            'delete_ts' => 'Delete Ts',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::class, ['id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::class, ['id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLesson()
    {
        return $this->hasOne(Lesson::class, ['id' => 'lesson_id']);
    }
}
