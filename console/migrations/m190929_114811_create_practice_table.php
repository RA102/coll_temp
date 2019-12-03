<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%practice}}`.
 */
class m190929_114811_create_practice_table extends Migration
{
    private $tableName = 'public.practice';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer(),
            'teacher_course_id' => $this->integer(),
            'teacher' => 'jsonb',
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
