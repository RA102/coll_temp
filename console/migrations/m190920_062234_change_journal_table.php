<?php

use yii\db\Migration;

/**
 * Class m190920_062234_change_journal_table
 */
class m190920_062234_change_journal_table extends Migration
{
    private $tableName = 'organization.journal';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'institution_id' => $this->integer(),
            'group_id' => $this->integer(),
            'teacher_course_id' => $this->integer(),
            'type' => $this->integer(),
            'date_ts' => $this->dateTime()->notNull(),
            'data' => $this->text() . '[]',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190920_062234_change_journal_table cannot be reverted.\n";

        return false;
    }
    */
}
