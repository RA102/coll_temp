<?php

use yii\db\Migration;

/**
 * Class m190927_105728_change_ktp_table
 */
class m190927_105728_change_ktp_table extends Migration
{
    private $tableName = 'public.ktp';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableName, 'lesson_number');
        $this->dropColumn($this->tableName, 'lesson_topic');
        $this->dropColumn($this->tableName, 'week');
        $this->dropColumn($this->tableName, 'type');

        $this->addColumn($this->tableName, 'lessons', 'jsonb');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'lessons');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190927_105728_change_ktp_table cannot be reverted.\n";

        return false;
    }
    */
}
