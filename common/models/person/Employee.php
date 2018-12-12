<?php

namespace common\models\person;

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
            'type' => Person::TYPE_EMPLOYEE,
        ]);
    }
}
