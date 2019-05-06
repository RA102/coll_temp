<?php

namespace common\helpers;

use common\models\ReceptionExamGrade;

class ReceptionExamGradeHelper
{
    public static function getGradeTypeList()
    {
        return [
            ReceptionExamGrade::GRADE_TYPE_LOGICAL => 'Логическая',
            ReceptionExamGrade::GRADE_TYPE_TEST => '25 - бальная для тестирования',
            ReceptionExamGrade::GRADE_TYPE_5 => 'Пятибальная для вступительных экзаменов',
        ];
    }

    public static function getGradeTypeLabels($type)
    {
        switch ($type) {
            case ReceptionExamGrade::GRADE_TYPE_LOGICAL:
                return [
                    '0' => 'Не рекомендован',
                    '1' => 'Рекомендован',
                ];
            case ReceptionExamGrade::GRADE_TYPE_TEST:
                $options = [];
                for ($i = 0; $i <= 25; $i++) {
                    $options[$i] = $i;
                }
                return $options;
            case ReceptionExamGrade::GRADE_TYPE_5:
                return [
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ];
            default:
                throw new \Exception("Grade type invalid");
        }
    }

    public static function getGradeTypePoints($type)
    {
        switch ($type) {
            case ReceptionExamGrade::GRADE_TYPE_LOGICAL:
                return [
                    '0' => 0,
                    '1' => 100,
                ];
            case ReceptionExamGrade::GRADE_TYPE_TEST:
                $options = [];
                for ($i = 0; $i <= 25; $i++) {
                    $options[$i] = $i;
                }
                return $options;
            case ReceptionExamGrade::GRADE_TYPE_5:
                return [
                    '3' => 8,
                    '4' => 17,
                    '5' => 25,
                ];
            default:
                throw new \Exception("Grade type invalid");
        }
    }
}