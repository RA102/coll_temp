<?php

namespace common\services\organization;

use common\models\organization\InstitutionSpecialityInfo;

class SpecialityService
{
    public function unlink(int $specialityId): void
    {
        $specialityInfo = InstitutionSpecialityInfo::findOne($specialityId);
        $specialityInfo->is_deleted = true;
        $specialityInfo->save();
    }
}