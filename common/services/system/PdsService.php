<?php
namespace common\services\system;

use common\models\system\Setting;

class PdsService
{
    public function saveToken(string $new_token): bool
    {
        $model = Setting::findOne(['name' => Setting::PDS_TOKEN_NAME]);

        if ($model) {
            $model->value = $new_token;
        } else {
            $model = Setting::addPdsToken($new_token);
        }

        return $model->save();
    }
}