<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule}}`.
 */
class m191004_054701_create_schedule_table extends Migration
{
    private $tableName = 'public.schedule';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer(),
            'weekday' => $this->integer(),
            'discipline_id' => $this->integer(),
            'teacher_id' => $this->integer(),
            'lesson_number' => $this->integer(),
            'classroom_id' => $this->integer(),
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
