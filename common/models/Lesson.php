<?php

namespace common\models;

use common\helpers\SchemeHelper;
use common\models\person\Person;
use Yii;

/**
 * This is the model class for table "lesson".
 *
 * @property int $id
 * @property int $teacher_course_id
 * @property int $teacher_id
 * @property string $date_ts
 * @property int $duration
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property TeacherCourse $teacherCourse
 */
class Lesson extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PUBLIC . 'lesson';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_course_id', 'date_ts'], 'required'],
            [['teacher_course_id', 'teacher_id', 'duration'], 'default', 'value' => null],
            [['teacher_course_id', 'teacher_id', 'duration'], 'integer'],
            [['date_ts'], 'safe'],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::class, 'targetAttribute' => ['teacher_id' => 'id']],
            [['teacher_course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['teacher_course_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'teacher_course_id' => Yii::t('app', 'Teacher Course ID'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'date_ts' => Yii::t('app', 'Date TS'),
            'duration' => Yii::t('app', 'Duration'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
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
