<?php

namespace common\services\person;

use common\models\organization\Group;
use common\models\person\Student;

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
}
