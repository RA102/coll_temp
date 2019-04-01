<?php

namespace common\services\organization;

use common\models\link\StudentGroupLink;
use common\models\organization\Group;
use common\models\organization\Institution;
use yii\helpers\ArrayHelper;

class GroupService
{
    // TODO getGroup(Institution $institution, $id): Group

    public function getAssociativeByClass(int $class, int $institution_id): array
    {
        $formattedGroups = [];

        /* @var Group[] $groups */
        $groups = Group::find()->where(['class' => $class, 'institution_id' => $institution_id])->all();

        foreach ($groups as $group) {
            $formattedGroups[] = [
                'id' => $group->id,
                'name' => $group->caption_current,
            ];
        }

        return $formattedGroups;
    }

    public function getGroups(Institution $institution)
    {
        return Group::find()->andWhere([
            'institution_id' => $institution->id,
        ])->all();
    }

    /**
     * @param Institution $institution
     * @param $id
     * @return array|null|\yii\db\ActiveRecord|Group
     */
    public function getGroup(Institution $institution, $id)
    {
        return Group::find()->andWhere([
            'institution_id' => $institution->id,
        ])->andWhere([
            'id' => $id
        ])->one();
    }

    public function getByClass(int $class, int $institution_id): array
    {
        $groups = Group::find()->where(['class' => $class, 'institution_id' => $institution_id])->all();
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
        /* @var StudentGroupLink $link */
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