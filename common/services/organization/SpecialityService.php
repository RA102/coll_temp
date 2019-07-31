<?php

namespace common\services\organization;

use common\models\handbook\Speciality;
use common\models\organization\InstitutionSpecialityInfo;

class SpecialityService
{
    /**
     * Remove speciality to institution
     * @param int $specialityInfoId
     */
    public function unlink(int $specialityInfoId)
    {
        $specialityInfo = InstitutionSpecialityInfo::findOne($specialityInfoId);
        $specialityInfo->is_deleted = true;
        $specialityInfo->save();
    }

    /**
     * Add speciality to institution
     * @param int $specialityId
     * @param int $institutionId
     */
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