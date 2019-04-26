<?php

namespace common\services\organization;

use common\models\organization\Institution;
use common\models\organization\InstitutionDiscipline;

class InstitutionDisciplineService
{
    /**
     * @param Institution $institution
     * @return array|\yii\db\ActiveRecord[]|InstitutionDiscipline[]
     */
    public function getInstitutionDisciplines(Institution $institution)
    {
        return InstitutionDiscipline::find()
            ->andWhere(['institution_id' => $institution->id])
            ->all();
    }

    /**
     * @param Institution $institution
     * @param $id
     * @return array|null|\yii\db\ActiveRecord|InstitutionDiscipline
     */
    public function getInstitutionDiscipline(Institution $institution, $id)
    {
        return InstitutionDiscipline::find()
            ->andWhere([
                'institution_id' => $institution->id,
                'id' => $id
            ])
            ->one();
    }
}