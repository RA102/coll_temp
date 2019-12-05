<?php

use yii\db\Migration;

/**
 * Class m191205_093403_delete_admin_and_superadmin_roles_from_person_type_table
 */
class m191205_093403_delete_admin_and_superadmin_roles_from_person_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete('person.person_type', ['name' => 'superadmin']);
        $this->delete('person.person_type', ['name' => 'admin']);
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
        echo "m191205_093403_delete_admin_and_superadmin_roles_from_person_type_table cannot be reverted.\n";

        return false;
    }
    */
}
