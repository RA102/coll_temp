<?php

use yii\db\Migration;

/**
 * Class m191203_050610_change_superadmin_role
 */
class m191203_050610_change_superadmin_role extends Migration
{
    private $tableName = 'person.person';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('UPDATE ' . $this->tableName . ' SET person_type = \'superadmin\' WHERE id = 1');
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
        echo "m191203_050610_change_superadmin_role cannot be reverted.\n";

        return false;
    }
    */
}
