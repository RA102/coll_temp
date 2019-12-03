<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%journal}}`.
 */
class m190905_043459_create_journal_table extends Migration
{
    private $tableName = 'organization.journal';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'type' => $this->integer(),
            'institution_id' => $this->integer(),
            'group_id' => $this->integer(),
            'teacher_course_id' => $this->integer(),
            'teacher_id' => $this->integer(),
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
