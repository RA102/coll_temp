<?php

namespace frontend\models\forms;

use common\models\Lesson;
use common\models\organization\Group;
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
    public $start;
    public $end;
    public $title;
    public $groups;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_course_id'], 'required'],
            [['teacher_course_id'], 'integer'],
            [['start', 'end'], 'required'],
            [['start', 'end'], 'string'],
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
            'start' => Yii::t('app', 'Start Date'),
            'end' => Yii::t('app', 'End Date'),
        ];
    }

    public static function createFromLesson(Lesson $lesson)
    {
        $startDate = \DateTime::createFromFormat('Y-m-d H:i:s', $lesson->date_ts);
        $endDate = (clone $startDate)->add(new \DateInterval('PT' . $lesson->duration . 'M'));

        $model = new static();
        $model->id = $lesson->id;
        $model->teacher_course_id = $lesson->teacher_course_id;
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
        $lesson->date_ts = $startDate->format('Y-m-d H:i:s');
        $lesson->duration = ($endDate->getTimestamp() - $startDate->getTimestamp()) / 60;

        return $lesson;
    }
}
