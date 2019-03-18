<?php

namespace common\services;

use common\models\Lesson;
use common\models\organization\Group;
use common\models\organization\Institution;
use common\models\organization\InstitutionDiscipline;
use common\models\person\Student;
use common\models\TeacherCourse;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class LessonService
{
    /**
     * @param TeacherCourse $teacherCourse
     * @return Lesson[]
     */
    public function getTeacherCourseLessons(TeacherCourse $teacherCourse)
    {
        return Lesson::find()->andWhere([
            'teacher_course_id' => $teacherCourse->id,
        ])->all();
    }

    /**
     * @param $id
     * @return Lesson|null
     */
    public function getLesson($id)
    {
        return Lesson::findOne($id);
    }

    /**
     * @param Institution $institution
     * @param $id
     * @return Lesson|ActiveRecord|null
     */
    public function getInstitutionLesson(Institution $institution, $id)
    {
        return Lesson::find()->joinWith([
            /** @see Lesson::getTeacherCourse() */
            'teacherCourse' => function (ActiveQuery $query) use ($institution) {
                return $query->joinWith([
                    /** @see TeacherCourse::getCourse() */
                    'course' => function (ActiveQuery $query) use ($institution) {
                        /** @see Course::getInstitutionDiscipline() */
                        return $query->joinWith([
                            'institutionDiscipline' => function (ActiveQuery $query) use ($institution) {
                                /** @see InstitutionDiscipline::$institution_id */
                                return $query->andWhere([
                                    InstitutionDiscipline::tableName() . '.institution_id' => $institution->id,
                                ]);
                            }
                        ]);
                    }
                ]);
            }
        ])->andWhere([
            Lesson::tableName() . '.id' => $id
        ])->one();
    }

    public function getStudentLesson(Student $student, $id)
    {
        return Lesson::find()->joinWith([
            /** @see Lesson::getTeacherCourse() */
            'teacherCourse' => function (ActiveQuery $query) use ($student) {
                return $query->joinWith([
                    /** @see TeacherCourse::getGroups() */
                    'groups' => function (ActiveQuery $query) use ($student) {
                        /** @see Group::getStudents() */
                        return $query->joinWith([
                            'students' => function (ActiveQuery $query) use ($student) {
                                /** @see Student::$id */
                                return $query->andWhere([
                                    Student::tableName() . '.id' => $student->id,
                                ]);
                            }
                        ]);
                    }
                ]);
            }
        ])->andWhere([
            Lesson::tableName() . '.id' => $id
        ])->one();
    }
}