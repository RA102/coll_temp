<?php

namespace common\services\organization;

use common\models\link\StudentGroupLink;
use common\models\organization\Group;
use common\models\organization\Institution;
use yii\helpers\ArrayHelper;

class GroupService
{
    // TODO getGroup(Institution $institution, $id): Group

    /**
     * List of groups in associative array filtered by class
     * @param int $class
     * @param int $institution_id
     * @param int|null $education_form
     * @param int|null $education_pay_form
     * @param int|null $speciality_id
     * @param string|null $language
     * @return array
     */
    public function getAssociativeByClass(
        int $class,
        int $institution_id,
        int $education_form = null,
        int $education_pay_form = null,
        int $speciality_id = null,
        string $language = null
    ): array {
        $formattedGroups = [];

        /* @var Group[] $groups */
        $groups = Group::find()->where(['class' => $class, 'institution_id' => $institution_id])
            ->andWhere(['IS', 'delete_ts', new \yii\db\Expression('NULL')])
            ->andWhere([
                'OR',
                ['organization.group.type' => 1], // type "studying process", from study.bilimal.kz
                ['organization.group.type' => null] // groups created in college.bilimal.kz
            ])
            ->andFilterWhere([
                'education_form' => $education_form,
                'education_pay_form' => $education_pay_form,
                'speciality_id' => $speciality_id,
                'language' => $language
            ])->all();

        foreach ($groups as $group) {
            $formattedGroups[] = [
                'id'   => $group->id,
                'name' => $group->caption_current,
            ];
        }

        return $formattedGroups;
    }

    public function getGroups(Institution $institution)
    {
        return Group::find()
            ->andWhere([
                'OR',
                ['organization.group.type' => 1], // type "studying process", from study.bilimal.kz
                ['organization.group.type' => null] // groups created in college.bilimal.kz
            ])->andWhere(['institution_id' => $institution->id])
            ->all();
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

    /**
     * List of groups by class
     * @param int $class
     * @param int $institution_id
     * @return array
     */
    public function getByClass(int $class, int $institution_id): array
    {
        $groups = Group::find()
            ->where(['class' => $class, 'institution_id' => $institution_id])
            ->andWhere(['IS', 'delete_ts', new \yii\db\Expression('NULL')])
            ->all();
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

    /**
     * @param int $id
     * @param int $group_id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function deleteStudent(int $id, int $group_id)
    {
        /* @var StudentGroupLink $link */
        StudentGroupLink::find()
            ->where(['student_id' => $id])
            ->andWhere(['group_id' => $group_id])
            ->one()
            ->delete();
    }
}