<?php

use yii\db\Migration;

/**
 * Handles the creation of table `student_grade`.
 */
class m190304_055156_create_student_grade_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('public.student_grade', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer()->notNull(),
            'type' => $this->smallInteger(),
            'value' => $this->smallInteger(),
            'course_id' => $this->integer(),
            'lesson_id' => $this->integer(),
            'foreign_id' => $this->integer(),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->addForeignKey('fk_student_grade_2_person', 'public.student_grade', 'student_id', 'person.person', 'id');
        $this->addForeignKey('fk_student_grade_2_course', 'public.student_grade', 'course_id', 'public.course', 'id');
        $this->addForeignKey('fk_student_grade_2_lesson', 'public.student_grade', 'lesson_id', 'public.lesson', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_student_grade_2_lesson', 'public.student_grade');
        $this->dropForeignKey('fk_student_grade_2_course', 'public.student_grade');
        $this->dropForeignKey('fk_student_grade_2_person', 'public.student_grade');

        $this->dropTable('public.student_grade');
    }
}
