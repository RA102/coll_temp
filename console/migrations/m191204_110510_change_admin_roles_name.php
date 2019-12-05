<?php

use yii\db\Migration;

/**
 * Class m191204_110510_change_admin_roles_name
 */
class m191204_110510_change_admin_roles_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('person.person_type', [
            'name' => 'college_superadmin', 
            'group' => 1, 
            'caption' => '{"kk": "Суперадминистратор системы", "ru": "Суперадминистратор системы"}',
        ]);

        $this->insert('person.person_type', [
            'name' => 'college_radmin', 
            'group' => 1, 
            'caption' => '{"kk": "Администратор колледжа", "ru": "Администратор колледжа"}',
        ]);
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
        echo "m191204_110510_change_admin_roles_name cannot be reverted.\n";

        return false;
    }
    */
}
