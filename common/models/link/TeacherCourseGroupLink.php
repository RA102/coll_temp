<?php

namespace common\models\link;

use common\models\organization\Group;
use common\models\TeacherCourse;
use Yii;

/**
 * This is the model class for table "link.teacher_course_group_link".
 *
 * @property int $id
 * @property int $teacher_course_id
 * @property int $group_id
 * @property string $create_ts
 * @property string $delete_ts
 */
class TeacherCourseGroupLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link.teacher_course_group_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_course_id', 'group_id'], 'required'],
            [['teacher_course_id', 'group_id'], 'default', 'value' => null],
            [['teacher_course_id', 'group_id'], 'integer'],
            [['create_ts', 'delete_ts'], 'safe'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::class, 'targetAttribute' => ['group_id' => 'id']],
            [['teacher_course_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeacherCourse::class, 'targetAttribute' => ['teacher_course_id' => 'id']],
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
            'group_id' => Yii::t('app', 'Group ID'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherCourses()
    {
        return $this->hasOne(TeacherCourse::class, ['teacher_course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }
}
