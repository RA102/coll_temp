<?php

namespace common\services\organization;

use common\models\link\StudentGroupLink;
use common\models\organization\Group;
use yii\helpers\ArrayHelper;

class GroupService
{
    // TODO getGroup(Institution $institution, $id): Group

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

    public function addStudent(int $id, int $group_id)
    {
        $link = StudentGroupLink::find()
            ->where(['student_id' => $id])
            ->andWhere(['group_id' => $group_id])
            ->one() ?? new StudentGroupLink();

        $link->student_id = $id;
        $link->group_id = $group_id;
        $link->delete_ts = null;
        $link->save();
    }

    public function deleteStudent(int $id, int $group_id)
    {
        $link = StudentGroupLink::find()
            ->where(['student_id' => $id])
            ->andWhere(['group_id' => $group_id])
            ->one();

        if ($link) {
            $link->delete_ts = date('Y-m-d H:i:s');
            $link->save();
        }
    }
}