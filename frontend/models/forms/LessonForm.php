<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

class LessonForm extends Model
{
    public function formName()
    {
        return '';
    }

    public $teacher_course_id;
    public $start_date;
    public $end_date;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_course_id'], 'required'],
            [['teacher_course_id'], 'integer'],
            [['start_date', 'end_date'], 'required'],
            [['start_date', 'end_date'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'teacher_course_id' => Yii::t('app', 'Teacher Course ID'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
        ];
    }
}
