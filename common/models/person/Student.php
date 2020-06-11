<?php

namespace common\models\person;

use common\helpers\PersonTypeHelper;
use common\models\link\StudentGroupLink;
use common\models\organization\Group;
use common\models\organization\Journal;
use common\models\ReceptionGroup;

/**
 * This is the model class for table "person.person".
 *
 * @property StudentGroupLink[] $studentGroupLinks
 * @property Group $group
 */
class Student extends Person
{
    public function init()
    {
        parent::init();

        $this->type = Person::TYPE_STUDENT;
    }

    public function attributeLabels()
    {
        return [
            'group.caption' => 'Группа',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {
        return parent::find(); //->andWhere([
            //static::tableName() //. '.type' => Person::TYPE_STUDENT,
        //]);
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

    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id'])
            ->viaTable('link.student_group_link', ['student_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptionGroup()
    {
        return $this->hasOne(ReceptionGroup::class, ['id' => 'reception_group_id'])
            ->viaTable('link.entrant_reception_group_link', ['entrant_id' => 'id']);
    }

    public function checkAttendance($type, $group_id, $student_id, $teacher_course_id, $date)
    {
        $journal = Journal::find()
                    ->where(['group_id' => $group_id])
                    ->andWhere(['date_ts' => $date])
                    ->andWhere(['teacher_course_id' => $teacher_course_id])
                    ->andWhere(['type' => $type])
                    ->one();

        if($journal !== null) {
            $data = $journal->data;
            $attendance = $data[$student_id]['attendance'];
            $mark = $data[$student_id]['mark'];
            $values = [$attendance, $mark];
            return $values;
        }
    }

}
