<?php

use yii\db\Migration;

/**
 * Class m191008_224653_add_columns_to_required_disciplines_table
 */
class m191008_224653_add_columns_to_required_disciplines_table extends Migration
{
    private $tableName = 'public.required_disciplines';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'discipline_id', $this->integer());
        $this->addColumn($this->tableName, 'teacher_id', 'jsonb');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'discipline_id');
        $this->dropColumn($this->tableName, 'teacher_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_224653_add_columns_to_required_disciplines_table cannot be reverted.\n";

        return false;
    }
    */
}
