<?php

use yii\db\Migration;

/**
 * Class m191008_015202_add_group_id_to_required_disciplines_table
 */
class m191008_015202_add_group_id_to_required_disciplines_table extends Migration
{
    private $tableName = 'public.required_disciplines';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'group_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'group_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_015202_add_group_id_to_required_disciplines_table cannot be reverted.\n";

        return false;
    }
    */
}
