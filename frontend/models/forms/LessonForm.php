<?php

namespace frontend\models\forms;

use common\models\Lesson;
use common\models\organization\Group;
use common\models\TeacherCourse;
use Yii;
use yii\base\Model;

class LessonForm extends Model
{
    public function formName()
    {
        return '';
    }

    public $id;
    public $teacher_course_id;
    public $teacher_id;
    public $start;
    public $end;
    public $title;
    public $groups;
    public $weeks;
    public $group_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_course_id', 'group_id'], 'required'],
            [['teacher_course_id', 'teacher_id', 'group_id'], 'integer'],
            [['start', 'end'], 'required'],
            [['start', 'end', 'weeks'], 'string'],
            [['id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'teacher_course_id' => Yii::t('app', 'Teacher Course ID'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'group_id' => Yii::t('app', 'Group ID'),
            'start' => Yii::t('app', 'Lesson Start Date'),
            'end' => Yii::t('app', 'Lesson End Date'),
            'weeks' => 'Weeks',
        ];
    }

    public static function createFromLesson(Lesson $lesson, $group_id=null)
    {
        $startDate = \DateTime::createFromFormat('Y-m-d H:i:s', $lesson->date_ts);
        $endDate = (clone $startDate)->add(new \DateInterval('PT' . $lesson->duration . 'M'));

        $model = new static();
        $model->id = $lesson->id;
        $model->teacher_course_id = $lesson->teacher_course_id;
        $model->teacher_id = $lesson->teacher_id;
        if ($group_id !== null) {
            $model->group_id = $group_id;
        } else $model->group_id = $lesson->group_id;
        $model->start = $startDate->format(DATE_ATOM);
        $model->end = $endDate->format(DATE_ATOM);

        $model->title = $lesson->teacherCourse->getFullname();
        $model->groups = array_map(function (Group $group) {
            return $group->caption_current;
        }, $lesson->teacherCourse->groups);

        return $model;
    }

    public function apply(Lesson $lesson)
    {
        $startDate = \DateTime::createFromFormat('Y-m-d H:i:s', $this->start);
        $endDate = \DateTime::createFromFormat('Y-m-d H:i:s', $this->end);

        $lesson->teacher_course_id = $this->teacher_course_id;
        $lesson->teacher_id = $this->teacher_id;
        $lesson->date_ts = $startDate->format('Y-m-d H:i:s');
        $lesson->duration = ($endDate->getTimestamp() - $startDate->getTimestamp()) / 60;
        $lesson->group_id = $this->group_id;

        return $lesson;
    }
}
