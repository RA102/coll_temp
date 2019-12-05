<?php

use yii\db\Migration;

/**
 * Class m191205_093040_update_roles_in_person_table
 */
class m191205_093040_update_roles_in_person_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('person.person', ['person_type' => 'college_superadmin'], ['person_type' => 'superadmin']);
        $this->update('person.person', ['person_type' => 'college_admin'], ['person_type' => 'admin']);
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
        echo "m191205_093040_update_roles_in_person_table cannot be reverted.\n";

        return false;
    }
    */
}
