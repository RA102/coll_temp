<?php

namespace common\services\organization;

use common\models\handbook\Speciality;
use common\models\organization\InstitutionSpecialityInfo;

class SpecialityService
{
    public function unlink(int $specialityInfoId): void
    {
        $specialityInfo = InstitutionSpecialityInfo::findOne($specialityInfoId);
        $specialityInfo->is_deleted = true;
        $specialityInfo->save();
    }

    public function link(int $specialityId, int $institutionId)
    {
        $speciality = Speciality::findOne($specialityId);
        if (!$speciality->hasChildren()) {
            $specialityInfo = InstitutionSpecialityInfo::find()
                ->where(['institution_id' => $institutionId, 'speciality_id' => $specialityId])->one()
                ?? new InstitutionSpecialityInfo();
            $specialityInfo->speciality_id = $specialityId;
            $specialityInfo->institution_id = $institutionId;
            $specialityInfo->is_deleted = false;
            $specialityInfo->save();
        }
    }
}