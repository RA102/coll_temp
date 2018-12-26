<?php

namespace common\services\organization;

use common\models\organization\InstitutionApplication;
use frontend\models\SignupForm;

class InstitutionApplicationService
{
    public function create(SignupForm $form)
    {
        $model = new InstitutionApplication();
        $model->setAttributes($form->attributes);
        $model->street = $form->street_id;
        $model->type_id = end($form->type_ids) ?? null;
        $model->city_id = end($form->city_ids) ?? null;
        $model->save();
    }
}
