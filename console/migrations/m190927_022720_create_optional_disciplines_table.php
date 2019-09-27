<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%optional_disciplines}}`.
 */
class m190927_022720_create_optional_disciplines_table extends Migration
{
    private $tableName = 'public.optional_disciplines';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'discipline_id' => $this->integer(),
            'teacher_id' => $this->integer(),
            'semester' => $this->integer(),
            'lections_hours' => 'jsonb',
            'seminars_hours' => 'jsonb',
            'course_works_hours' => 'jsonb',//курсовые работы
            'tests_hours' => 'jsonb', //контрольные работы
            'offsets_hours' => 'jsonb', //зачёт
            'consultations_hours' => 'jsonb', 
            'exams_hours' => 'jsonb', //экзамены
            'students' => 'jsonb',
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
