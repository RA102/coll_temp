<?php

use yii\db\Migration;

/**
 * Class m190922_055431_change_data_column_type_in_journal_table
 */
class m190922_055431_change_data_column_type_in_journal_table extends Migration
{
    private $tableName = 'organization.journal';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableName, 'data');
        $this->addColumn($this->tableName, 'data', 'jsonb');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'data');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190922_055431_change_data_column_type_in_journal_table cannot be reverted.\n";

        return false;
    }
    */
}
