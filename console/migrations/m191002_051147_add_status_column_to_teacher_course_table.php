<?php

use yii\db\Migration;

/**
 * Handles adding status to table `{{%teacher_course}}`.
 */
class m191002_051147_add_status_column_to_teacher_course_table extends Migration
{
    private $tableName = 'public.teacher_course';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'status', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'status');
    }
}
