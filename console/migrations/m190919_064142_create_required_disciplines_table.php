<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%required_disciplines}}`.
 */
class m190919_064142_create_required_disciplines_table extends Migration
{
    private $tableName = 'public.required_disciplines';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'discipline_id' => $this->integer(),
            'group_id' => $this->integer(),
            'teacher_id' => $this->integer(),
            'semester' => $this->integer(),
            'lections_hours' => $this->string(),
            'seminars_hours' => $this->string(),
            'course_works_hours' => $this->string(),//курсовые работы
            'tests_hours' => $this->string(), //контрольные работы
            'consultations_hours' => $this->string(), 
            'exams_hours' => $this->string(), //экзамены
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
