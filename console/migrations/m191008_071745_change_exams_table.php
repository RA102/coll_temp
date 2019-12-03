<?php

use yii\db\Migration;

/**
 * Class m191008_071745_change_exams_table
 */
class m191008_071745_change_exams_table extends Migration
{
    private $tableName = 'public.exams';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'teacher_course_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'teacher_course_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_071745_change_exams_table cannot be reverted.\n";

        return false;
    }
    */
}
