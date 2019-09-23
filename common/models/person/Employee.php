<?php

namespace common\models\person;

use common\helpers\PersonTypeHelper;
use common\models\CommissionMemberLink;
use common\models\organization\InstitutionDiscipline;
use common\models\reception\Commission;

/**
 * This is the model class for table "person.person".
 */
class Employee extends Person
{
    public function init()
    {
        parent::init();

        $this->type = Person::TYPE_EMPLOYEE;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {
        return parent::find()->andWhere([
            static::tableName() . '.type' => Person::TYPE_EMPLOYEE,
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
        $model->type = Person::TYPE_EMPLOYEE;
        $model->person_type = PersonTypeHelper::PERSON_TYPE_TEACHER;

        return $model;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommissions()
    {
        return $this->hasMany(Commission::class, ['id' => 'commission_id'])
            ->viaTable('link.commission_member_link', ['member_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommissionMemberLinks()
    {
        return $this->hasMany(CommissionMemberLink::class, ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionDisciplines()
    {
        return $this->hasMany(InstitutionDiscipline::class, ['teachers' => 'id']);
    }

    
}
