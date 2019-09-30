<?php

use yii\db\Migration;

/**
 * Class m190930_062632_change_required_table
 */
class m190930_062632_change_required_table extends Migration
{
    private $tableName = 'public.required_disciplines';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!isset($tableName->columns['ktp'])) {
            $this->addColumn($this->tableName, 'ktp', 'jsonb');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'ktp');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190930_062632_change_required_table cannot be reverted.\n";

        return false;
    }
    */
}
