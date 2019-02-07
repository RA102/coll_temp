<?php

namespace common\models;

use common\helpers\SchemeHelper;
use Yii;

/**
 * This is the model class for table "course".
 *
 * @property int $id
 * @property int $discipline_id
 * @property array $caption
 * @property string $grades
 * @property int $status
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property Discipline $discipline
 * @property TeacherCourse[] $teacherCourses
 */
class Course extends \yii\db\ActiveRecord
{
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
            [['discipline_id'], 'required'],
            [['discipline_id', 'status'], 'default', 'value' => null],
            [['discipline_id', 'status'], 'integer'],
            [['caption'], 'safe'],
            [['grades'], 'string', 'max' => 255],
            [['discipline_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discipline::class, 'targetAttribute' => ['discipline_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'discipline_id' => Yii::t('app', 'Discipline ID'),
            'caption' => Yii::t('app', 'Caption'),
            'grades' => Yii::t('app', 'Grades'),
            'status' => Yii::t('app', 'Status'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscipline()
    {
        return $this->hasOne(Discipline::class, ['id' => 'discipline_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(TeacherCourse::class, ['course_id' => 'id'])->inverseOf('course');
    }
}
