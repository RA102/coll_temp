<?php

use yii\db\Migration;

/**
 * Class m190926_064114_change_required_disciplines_table
 */
class m190926_064114_change_required_disciplines_table extends Migration
{
    private $tableName = 'public.required_disciplines';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableName, 'semester');
        $this->dropColumn($this->tableName, 'lections_hours');
        $this->dropColumn($this->tableName, 'seminars_hours');
        $this->dropColumn($this->tableName, 'course_works_hours');
        $this->dropColumn($this->tableName, 'tests_hours');
        $this->dropColumn($this->tableName, 'consultations_hours');
        $this->dropColumn($this->tableName, 'exams_hours');

        $this->addColumn($this->tableName, 'lections_hours', 'jsonb');
        $this->addColumn($this->tableName, 'seminars_hours', 'jsonb');
        $this->addColumn($this->tableName, 'course_works_hours', 'jsonb');
        $this->addColumn($this->tableName, 'tests_hours', 'jsonb');
        $this->addColumn($this->tableName, 'offsets_hours', 'jsonb');
        $this->addColumn($this->tableName, 'consultations_hours', 'jsonb');
        $this->addColumn($this->tableName, 'exams_hours', 'jsonb');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'lections_hours');
        $this->dropColumn($this->tableName, 'seminars_hours');
        $this->dropColumn($this->tableName, 'course_works_hours');
        $this->dropColumn($this->tableName, 'tests_hours');
        $this->dropColumn($this->tableName, 'offsets_hours');
        $this->dropColumn($this->tableName, 'consultations_hours');
        $this->dropColumn($this->tableName, 'exams_hours');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190926_064114_change_required_disciplines_table cannot be reverted.\n";

        return false;
    }
    */
}
