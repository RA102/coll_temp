<?php

namespace common\models\person;

/**
 * This is the model class for table "person.person".
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
            'type' => Person::TYPE_STUDENT,
        ]);
    }
}
