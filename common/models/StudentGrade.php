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
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property Student $student
 */
class StudentGrade extends \yii\db\ActiveRecord
{
    const TYPE_LESSON = 1;
    const TYPE_SESSION = 2;
    const TYPE_COURSE = 3;

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
            [['student_id', 'type', 'value'], 'default', 'value' => null],
            [['student_id', 'type', 'value'], 'integer'],
            [['create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::class, 'targetAttribute' => ['student_id' => 'id']],
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
}
