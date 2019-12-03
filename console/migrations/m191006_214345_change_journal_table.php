<?php

use yii\db\Migration;

/**
 * Class m191006_214345_change_journal_table
 */
class m191006_214345_change_journal_table extends Migration
{
    private $tableName = 'organization.journal';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableName, 'teacher_course_id');

        $this->addColumn($this->tableName, 'discipline_type', $this->integer());
        $this->addColumn($this->tableName, 'discipline_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'discipline_type');
        $this->dropColumn($this->tableName, 'discipline_id');

        $this->addColumn($this->tableName, 'teacher_course_id', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191006_214345_change_journal_table cannot be reverted.\n";

        return false;
    }
    */
}
