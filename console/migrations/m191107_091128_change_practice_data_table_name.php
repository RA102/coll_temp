<?php

use yii\db\Migration;

/**
 * Class m191107_091128_change_practice_data_table_name
 */
class m191107_091128_change_practice_data_table_name extends Migration
{
    private $tableName = 'public.practice_data';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable($this->tableName);
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
        echo "m191107_091128_change_practice_data_table_name cannot be reverted.\n";

        return false;
    }
    */
}
