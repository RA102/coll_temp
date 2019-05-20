<?php

use yii\db\Migration;

/**
 * Class m190510_130713_add_columns_to_admission_protocol_table
 */
class m190510_130713_add_columns_to_admission_protocol_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('reception.admission_protocol', 'commission_members', 'INT[] NOT NULL');
        $this->addColumn('reception.admission_protocol', 'agendas', 'TEXT[] NOT NULL');
        $this->addColumn('reception.admission_protocol', 'issues', 'JSONB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('reception.admission_protocol', 'commission_members');
        $this->dropColumn('reception.admission_protocol', 'agendas');
        $this->dropColumn('reception.admission_protocol', 'issues');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190510_130713_add_columns_to_admission_protocol_table cannot be reverted.\n";

        return false;
    }
    */
}
