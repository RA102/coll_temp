<?php

namespace common\services;

use common\models\Lesson;
use common\models\TeacherCourse;

class LessonService
{
    /**
     * @param TeacherCourse $teacherCourse
     * @return Lesson[]
     */
    public function getLessons(TeacherCourse $teacherCourse)
    {
        return Lesson::find()->andWhere([
            'teacher_course_id' => $teacherCourse->id,
        ])->all();
    }
}