<?php

namespace common\services\organization;

use common\models\organization\Group;

class GroupService
{
    public function getByClass(int $class): array
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
}