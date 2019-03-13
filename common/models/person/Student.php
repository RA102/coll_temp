<?php

namespace common\models\person;

use common\helpers\PersonTypeHelper;
use common\models\link\StudentGroupLink;
use common\models\organization\Group;

/**
 * This is the model class for table "person.person".
 *
 * @property StudentGroupLink[] $studentGroupLinks
 */
class Student extends Person
{
    public function init()
    {
        parent::init();

        $this->type = Person::TYPE_STUDENT;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {
        return parent::find()->andWhere([
            'person.person.type' => Person::TYPE_STUDENT,
        ]);
    }

    /**
     * @param $portal_uid
     * @param $firstname
     * @param $lastname
     * @param $middlename
     * @param $iin
     * @return Person
     */
    public static function add($portal_uid, $firstname, $lastname, $middlename, $iin): Person
    {
        $model = parent::add($portal_uid, $firstname, $lastname, $middlename, $iin);
        $model->type = Person::TYPE_STUDENT;
        $model->person_type = PersonTypeHelper::PERSON_TYPE_STUDENT;

        return $model;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Group::class, ['id' => 'group_id'])
            ->viaTable('link.student_group_link', ['student_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentGroupLinks()
    {
        return $this->hasMany(StudentGroupLink::class, ['student_id' => 'id']);
    }
}
