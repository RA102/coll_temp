<?php

use yii\db\Migration;

/**
 * Class m191119_025616_update_person_type_table
 */
class m191119_025616_update_person_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('person.person_type', ['group' => '1'], ['name' => 'hr']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191119_025616_update_person_type_table cannot be reverted.\n";

        return false;
    }
    */
}
