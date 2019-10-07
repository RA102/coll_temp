<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%replacement_journal}}`.
 */
class m191007_050214_create_replacement_journal_table extends Migration
{
    private $tableName = 'organization.replacement_journal';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'date_ts' => $this->dateTime()->notNull(),
            'new_date_ts' => $this->dateTime(),
            'group_id' => $this->integer(),            
            'teacher_course_id' => $this->integer(),
            'new_teacher_course_id' => $this->integer(),
            'new_teacher_id' => $this->integer(),
            'reason' => $this->string(),
            'canceled' => $this->boolean(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
