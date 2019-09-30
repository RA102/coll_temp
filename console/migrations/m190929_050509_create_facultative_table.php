<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%facultative}}`.
 */
class m190929_050509_create_facultative_table extends Migration
{
    private $tableName = 'public.facultative';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'teacher_course_id' => $this->integer(),
            'group_id' => $this->integer(),
            'teacher_id' => $this->integer(),
            'hours' => 'jsonb',
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
