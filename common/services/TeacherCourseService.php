<?php

namespace common\services;

use common\models\Course;
use common\models\link\TeacherCourseGroupLink;
use common\models\organization\Group;
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
        return TeacherCourse::find()->andWhere([
            'course_id' => $course->id,
            TeacherCourse::tableName() . '.id' => $id,
        ])->one();
    }

    public function addGroup(TeacherCourse $teacherCourse, Group $group)
    {
        /* @var TeacherCourseGroupLink $link */
        $link = TeacherCourseGroupLink::find()
            ->andWhere([
                'teacher_course_id' => $teacherCourse->id,
                'group_id' => $group->id
            ])
            ->one() ?? new TeacherCourseGroupLink();

        $link->teacher_course_id = $teacherCourse->id;
        $link->group_id = $group->id;
        $link->delete_ts = null;
        if ($link->save()) {
            return true;
        }

        return false;
    }

    public function deleteGroup(TeacherCourse $teacherCourse, Group $group)
    {
        /* @var TeacherCourseGroupLink $link */
        $link = TeacherCourseGroupLink::find()
            ->andWhere([
                'teacher_course_id' => $teacherCourse->id,
                'group_id' => $group->id
            ])
            ->one();

        if ($link) {
            $link->delete_ts = date('Y-m-d H:i:s');
            if ($link->save()) {
                return true;
            }
        }

        return false;
    }
}