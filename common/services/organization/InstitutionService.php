<?php

namespace common\services\organization;

use common\forms\InstitutionForm;
use common\models\CountryUnit;
use common\models\organization\Institution;

class InstitutionService
{
    public function update(Institution $institution, InstitutionForm $institutionForm)
    {
        $institution->setAttributes($institutionForm->attributes);
        $institution->type_id = end($institutionForm->type_ids);
        $institution->city_id = end($institutionForm->city_ids);
        $institution->save();
    }

    public function getExistingCities() {
        return CountryUnit::find()->innerJoinWith('institutions')->all();
    }
}