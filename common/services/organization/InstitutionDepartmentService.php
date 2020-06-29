<?php

namespace common\services\organization;

use common\models\organization\Institution;
use common\models\organization\InstitutionDepartment;

class InstitutionDepartmentService
{
    /**
     * @param Institution $institution
     * @return array|\yii\db\ActiveRecord[]|InstitutionDepartment[]
     */
    public function getInstitutionDepartments(Institution $institution)
    {
        return InstitutionDepartment::find()
            ->andWhere(['institution_id' => $institution->id])
            ->all();
    }

    /**
     * @param Institution $institution
     * @param $id
     * @return array|null|\yii\db\ActiveRecord|InstitutionDepartment
     */
    public function getInstitutionDepartment(Institution $institution, $id)
    {
        return InstitutionDepartment::find()
            ->andWhere([
                'institution_id' => $institution->id,
                'id' => $id
            ])
            ->one();
    }

    public function getInstitutionExamDepartments(Institution $institution)
    {
        return InstitutionDepartment::find()
            ->andWhere(
                InstitutionDepartment::TYPE_EXAM . " = ANY(\"types\")"
            )
            ->andWhere([
                'institution_id' => $institution->id,
            ])
            ->all();
    }
}