<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%column_from_teacher_course}}`.
 */
class m191011_041704_drop_column_from_teacher_course_table extends Migration
{
    private $tableName = 'public.teacher_course';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableName, 'start_ts');
        $this->dropColumn($this->tableName, 'end_ts');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn($this->tableName, 'start_ts', $this->dateTime());
        $this->addColumn($this->tableName, 'end_ts', $this->dateTime());
    }
}
