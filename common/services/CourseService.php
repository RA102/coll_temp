<?php

namespace common\services;

use common\models\Course;
use common\models\organization\Institution;

class CourseService
{
    /**
     * @param Institution $institution
     * @param $id
     * @return array|null|\yii\db\ActiveRecord|Course
     */
    public function getCourse(Institution $institution, $id)
    {
        return $institution->getCourses()->andWhere([
            'id' => $id,
        ])->one();
    }
}