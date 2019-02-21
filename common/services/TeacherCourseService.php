<?php

namespace common\services;

use common\models\Course;
use common\models\TeacherCourse;

class TeacherCourseService
{
    /**
     * @param Course $course
     * @param $id
     * @return array|null|\yii\db\ActiveRecord|TeacherCourse
     */
    public function getTeacherCourse(Course $course, $id)
    {
        return $course->getTeacherCourses()->andWhere([
            'id' => $id,
        ])->one();
    }
}