<?php

namespace common\models\person;

use common\helpers\PersonTypeHelper;
use common\models\CommissionMemberLink;
use common\models\ReceptionGroup;

/**
 * This is the model class for table "person.person".
 */
class Entrant extends Person
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {
        return parent::find()->andWhere([
            'type' => Person::TYPE_ENTRANT,
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
        $model->type = Person::TYPE_ENTRANT;
        $model->person_type = PersonTypeHelper::PERSON_TYPE_ENTRANT;

        return $model;
    }

    public function init()
    {
        parent::init();

        $this->type = Person::TYPE_ENTRANT;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptionGroups()
    {
        return $this->hasMany(ReceptionGroup::class, ['id' => 'reception_group_id'])
            ->viaTable('link.entrant_reception_group_link', ['entrant_id' => 'id']);
    }
}
