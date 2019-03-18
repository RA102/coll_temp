<?php

namespace common\services\person;

use common\models\organization\Group;
use common\models\organization\Institution;
use common\models\person\Student;
use yii\db\ActiveQuery;

class StudentService
{
    public function getGroupStudents(Group $group)
    {
        return Student::find()->joinWith([
            /** @see Student::getStudentGroupLinks() */
            'studentGroupLinks' => function (\yii\db\ActiveQuery $query) use ($group) {
                $query->andWhere([
                    'link.student_group_link.group_id' => $group->id,
                ]);
            },
        ])->all();
    }

    /**
     * @param Institution $institution
     * @param $id
     * @return array|null|\yii\db\ActiveRecord|Student
     */
    public function getInstitutionStudent(Institution $institution, $id)
    {
        return Student::find()->joinWith([
            /** @see Student::getGroups() */
            'groups' => function (ActiveQuery $query) use ($institution) {
                /** @see Group::$institution_id */
                return $query->andWhere([
                    Group::tableName() . '.institution_id' => $institution->id,
                ]);
            }
        ])->andWhere([
            Student::tableName() . '.id' => $id,
        ])->one();
    }
}
