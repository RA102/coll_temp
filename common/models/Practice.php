<?php

namespace common\models;

use common\helpers\SchemeHelper;
use common\models\TeacherCourse;
use common\models\organization\Group;
use common\models\person\Employee;
use Yii;
use yii\db\ArrayExpression;

/**
 * This is the model class for table "practice".
 *
 * @property int $id
 * @property int $teacher_course_id
 * @property int $group_id
 * @property array $teacher
 * @property array $hours
 *
 */
class Practice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PUBLIC . 'practice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_course_id', 'group_id'], 'required'],
            [['teacher', 'hours'], 'default', 'value' => null],
            [['teacher', 'hours'], 'safe'],
            [['teacher_course_id', 'group_id'], 'integer'],
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'teacher_course_id' => Yii::t('app', 'Факультатив'),
            'group_id' => Yii::t('app', 'Group'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'hours' => 'Часов',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherCourse()
    {
        return $this->hasOne(TeacherCourse::class, ['id' => 'teacher_course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher($teacher_id)
    {
        return Employee::findOne(['id' => $teacher_id]);
    }

    public function forYear()
    {
        return $this->hours[1] + $this->hours[2];
    }

}
