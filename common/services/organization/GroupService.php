<?php

namespace common\services\organization;

use common\models\organization\Group;
use yii\helpers\ArrayHelper;

class GroupService
{
    public function getAssociativeByClass(int $class): array
    {
        $formattedGroups = [];

        $groups = Group::find()->where(['class' => $class])->all();

        foreach ($groups as $group) {
            $formattedGroups[] = [
                'id' => $group->id,
                'name' => $group->caption_current,
            ];
        }

        return $formattedGroups;
    }

    public function getByClass(int $class): array
    {
        $groups = Group::find()->where(['class' => $class])->all();
        return ArrayHelper::map($groups, 'id', 'caption_current');
    }
}