<?php

use yii\db\Migration;

/**
 * Class m191009_041230_change_practice_table
 */
class m191009_041230_change_practice_table extends Migration
{
    private $tableName = 'public.practice';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableName, 'group_id');
        $this->dropColumn($this->tableName, 'teacher_course_id');
        $this->dropColumn($this->tableName, 'teacher');
        $this->dropColumn($this->tableName, 'hours');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn($this->tableName, 'group_id', $this->integer());
        $this->addColumn($this->tableName, 'teacher_course_id', $this->integer());
        $this->addColumn($this->tableName, 'teacher_id', 'jsonb');
        $this->addColumn($this->tableName, 'hours', 'jsonb');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191009_041230_change_practice_table cannot be reverted.\n";

        return false;
    }
    */
}
