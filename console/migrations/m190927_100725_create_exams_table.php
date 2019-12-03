<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%exams}}`.
 */
class m190927_100725_create_exams_table extends Migration
{
    private $tableName = 'public.exams';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer(),
            'institution_discipline_id' => $this->integer(),
            'exam_type' => $this->integer(),
            'week' => $this->integer(),
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
