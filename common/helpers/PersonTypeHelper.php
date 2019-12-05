<?php

namespace common\helpers;

use common\models\person\PersonType;

class PersonTypeHelper
{
    #Глобальный админ системы
    const PERSON_TYPE_SUPER_ADMIN = 'college_superadmin';

    #Админ
    const EMPLOYEE_TYPE_ADMIN = 'college_admin';

    #Дефолтный тип для роли у работника
    const EMPLOYEE_TYPE_RANK_DEFAULT = 'teacher';

    #Студент
    const PERSON_TYPE_STUDENT = 'student';

    #Учитель
    const PERSON_TYPE_TEACHER = 'teacher';

    #Абитуриент
    const PERSON_TYPE_ENTRANT = 'entrant';

    #HR
    const PERSON_TYPE_HR = 'hr';

    #Директор колледжа
    const PERSON_TYPE_DIRECTOR = 'director';

    #Председатель попечительского совета
    const PERSON_TYPE_CHAIRMAN = 'chairman';

    #Заместитель директора колледжа по Учебной работе
    const PERSON_TYPE_DIRECTOR_DEPUTY_ACADEMIC = 'director_deputy_academic';

    #Заместитель директора колледжа по Учебно-воспитательной работе
    const PERSON_TYPE_DIRECTOR_DEPUTY_EDUCATION = 'director_deputy_education';

    #Заместитель директора колледжа по Учебно-производственной работе
    const PERSON_TYPE_DIRECTOR_DEPUTY_INSDUSTRIAL = 'director_deputy_industrial';

    #Заместитель директора по научно-методической работе (заведующий методическим кабинетом, методист)
    const PERSON_TYPE_DIRECTOR_DEPUTY_METHODIST = 'director_deputy_methodist';

    #Заместитель директора по хозяйственной части
    const PERSON_TYPE_DIRECTOR_DEPUTY_ECONOMIC = 'director_deputy_economic';

    #Специалист Приемной комиссии
    const PERSON_TYPE_ADMISSION_SPECIALIST = 'admission_specialist';

    #Менеджеры
    const PERSON_TYPE_MANAGER = 'manager';

    #Педагог-психолог
    const PERSON_TYPE_PSYCHOLOGIST = 'psychologist';

    #социальный-педагог
    const PERSON_TYPE_SOCIAL_TEACHER = 'social_teacher';

    #Персонал
    const PERSONT_TYPE_STAFF = 'staff';

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
            $caption = json_decode($model->caption, true);
            $result[$model->name] = $caption['ru'];
        }
        asort($result);

        return $result;
    }
}
