<?php

namespace common\services;

use common\models\Course;
use common\models\organization\Institution;
use yii\db\ActiveQuery;

class CourseService
{
    /**
     * @param Institution $institution
     * @param $id
     * @return array|null|\yii\db\ActiveRecord|Course
     */
    public function getCourse(Institution $institution, $id)
    {
        return Course::find()->joinWith([
            /** @see Course::getInstitutionDiscipline() */
            'institutionDiscipline' => function (ActiveQuery $query) use ($institution) {
                return $query->andWhere([
                    'institution_id' => $institution->id,
                ]);
            }
        ])->andWhere([
            Course::tableName() . '.id' => $id,
        ])->one();
    }
}