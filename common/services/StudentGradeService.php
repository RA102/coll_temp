<?php

namespace common\services;

use common\models\StudentGrade;

class StudentGradeService
{
    public function addStudentGrade(StudentGrade $studentGrade)
    {
        $studentGrade->save();

        return $studentGrade;
    }
}