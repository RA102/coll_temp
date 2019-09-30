<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ktp}}`.
 */
class m190927_104917_create_ktp_table extends Migration
{
    private $tableName = 'public.ktp';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer(),
            'institution_discipline_id' => $this->integer(),
            'teacher_id' => $this->integer(),
            'lesson_number' => $this->integer(),
            'lesson_topic' => $this->string(),
            'week' => $this->integer(),
            'type' => $this->integer(),
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
