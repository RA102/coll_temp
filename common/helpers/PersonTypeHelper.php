<?php

namespace common\helpers;

use common\models\person\PersonType;

class PersonTypeHelper
{
    #Админ
    const EMPLOYEE_TYPE_ADMIN = 'admin';
    #Дефолтный тип для роли у работника
    const EMPLOYEE_TYPE_RANK_DEFAULT = 'teacher';
    #Глобальный админ системы
    const PERSON_TYPE_SUPER_ADMIN = 'superadmin';
    #Студент
    const PERSON_TYPE_STUDENT = 'student';
    #Учитель
    const PERSON_TYPE_TEACHER = 'teacher';
    #Абитуриент
    const PERSON_TYPE_ENTRANT = 'entrant';
    #HR
    const PERSON_TYPE_HR = 'hr';

    #Группы для ролей пользователя
    const PERSON_TYPE_GROUP_EMPLOYEE = 1;     // работники
    const PERSON_TYPE_GROUP_PUPIL = 2;        // учащиеся
    const PERSON_TYPE_GROUP_PARENT = 3;       // родители
    const PERSON_TYPE_GROUP_SYSTEM = 4;       // системные
    const PERSON_TYPE_GROUP_ELSE = 0;         // другие

    public static function getList()
    {
        /* @var $models PersonType[] */
        $models = PersonType::find()
            ->where(['is_deleted' => false])
            ->all();
        $result = [];
        foreach ($models as $model) {
            $result[$model->name] = $model->name;
        }

        return $result;
    }
}
