<?php

use yii\db\Migration;

/**
 * Class m191002_102350_change_required_disciplines_table
 */
class m191002_102350_change_required_disciplines_table extends Migration
{
    private $tableName = 'public.required_disciplines';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableName, 'discipline_id');
        $this->dropColumn($this->tableName, 'teacher_id');
        $this->dropColumn($this->tableName, 'group_id');

        $this->addColumn($this->tableName, 'teacher_course_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'teacher_course_id');

        $this->addColumn($this->tableName, 'discipline_id', $this->integer());
        $this->addColumn($this->tableName, 'teacher_id', $this->integer());
        $this->addColumn($this->tableName, 'group_id', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191002_102350_change_required_disciplines_table cannot be reverted.\n";

        return false;
    }
    */
}
