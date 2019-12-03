<?php

use yii\db\Migration;

/**
 * Class m191007_014904_change_schedule_table
 */
class m191007_014904_change_schedule_table extends Migration
{
    private $tableName = 'public.schedule';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableName, 'teacher_id');
        $this->dropColumn($this->tableName, 'discipline_id');

        $this->addColumn($this->tableName, 'teacher_course_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'teacher_course_id');

        $this->addColumn($this->tableName, 'teacher_id', $this->integer());
        $this->addColumn($this->tableName, 'discipline_id', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191007_014904_change_schedule_table cannot be reverted.\n";

        return false;
    }
    */
}
