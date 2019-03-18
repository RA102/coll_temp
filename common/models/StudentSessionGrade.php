<?php

namespace common\models;

use common\models\person\Student;
use Yii;

/**
 * This is the model class for table "student_grade".
 *
 * @property int $lesson_id
 *
 * @property Course $course
 */
class StudentSessionGrade extends StudentGrade
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->type = self::TYPE_SESSION;
    }

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
        return array_merge(parent::rules(), [
            [['lesson_id'], 'default', 'value' => null],
            [['lesson_id'], 'integer'],
            [['lesson_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lesson::class, 'targetAttribute' => ['lesson_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::rules(), [
            'lesson_id' => 'Lesson ID',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLesson()
    {
        return $this->hasOne(Lesson::class, ['id' => 'lesson_id']);
    }
}
