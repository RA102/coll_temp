<?php

use yii\db\Migration;

/**
 * Class m191205_092840_update_roles_in_person_table
 */
class m191205_092840_update_roles_in_person_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('person.person_type', ['name' => 'college_admin'], ['name' => 'college_radmin']);
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
        echo "m191205_092840_update_roles_in_person_table cannot be reverted.\n";

        return false;
    }
    */
}
