<?php

namespace common\helpers;

use common\models\ReceptionExam;
use common\models\ReceptionExamGrade;

class ReceptionExamHelper
{
    public static function getTypeList()
    {
        return [
            ReceptionExam::TYPE_CREATIVE => 'Творческий экзамен',
            ReceptionExam::TYPE_INTERVIEW => 'Собеседование',
            ReceptionExam::TYPE_EXAM => 'Экзамен',
            ReceptionExam::TYPE_TEST => 'Тестирование',
        ];
    }

    /**
     * @param $examType
     * @return array|int
     * @throws \Exception
     */
    public static function examTypeToGradeTypeMap($examType) {
        switch ($examType) {
            case ReceptionExam::TYPE_CREATIVE:
            case ReceptionExam::TYPE_EXAM:
                return ReceptionExamGrade::GRADE_TYPE_5;
            case ReceptionExam::TYPE_TEST:
                return ReceptionExamGrade::GRADE_TYPE_TEST;
            case ReceptionExam::TYPE_INTERVIEW:
                return ReceptionExamGrade::GRADE_TYPE_LOGICAL;
            default:
                throw new \Exception("Exam type is invalid");
        }
    }
}