<?php

use yii\db\Migration;

/**
 * Class m191009_051716_change_professional_practice_table
 */
class m191009_051716_change_professional_practice_table extends Migration
{
    private $tableName = 'public.professional_practice';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableName, 'group_id');
        $this->dropColumn($this->tableName, 'weeks');

        $this->addColumn($this->tableName, 'caption', 'jsonb');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'caption');

        $this->addColumn($this->tableName, 'caption', $this->integer());
        $this->addColumn($this->tableName, 'caption', 'jsonb');        
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191009_051716_change_professional_practice_table cannot be reverted.\n";

        return false;
    }
    */
}
