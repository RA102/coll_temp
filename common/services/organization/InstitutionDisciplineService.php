<?php

namespace common\services\organization;

use common\models\organization\Institution;
use common\models\organization\InstitutionDiscipline;

class InstitutionDisciplineService
{
    public function getInstitutionDisciplines(Institution $institution)
    {
        return InstitutionDiscipline::find()
            ->andWhere(['institution_id' => $institution->id])
            ->all();
    }
}