<?php

use yii\db\Migration;

/**
 * Class m191008_232513_add_discipline_id_to_facultative_table
 */
class m191008_232513_add_discipline_id_to_facultative_table extends Migration
{
    private $tableName = 'public.facultative';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'discipline_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'discipline_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_232513_add_discipline_id_to_facultative_table cannot be reverted.\n";

        return false;
    }
    */
}
