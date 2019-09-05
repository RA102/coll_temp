<?php

use common\models\person\Person;
use yii\db\Migration;

/**
 * Class m190820_071522_add_current_insitution_to_person_table
 */
class m190820_071522_add_current_insitution_to_person_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Person::tableName(), 'current_institution', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Person::tableName(), 'current_institution');
    }
}