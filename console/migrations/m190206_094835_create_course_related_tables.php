<?php

use yii\db\Migration;

/**
 * Class m190206_094835_create_course_related_tables
 */
class m190206_094835_create_course_related_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('public.discipline', [
            'id' => $this->primaryKey(),
            'caption' => 'jsonb',
            'slug' => $this->string(),
            'status' => $this->integer(),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->createTable('public.course', [
            'id' => $this->primaryKey(),
            'discipline_id' => $this->integer()->notNull(),
            'caption' => 'jsonb',
            'grades' => $this->string(),
            'status' => $this->integer(),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->createTable('public.teacher_course', [
            'id' => $this->primaryKey(),
            'course_id' => $this->integer()->notNull(),
            'teacher_id' => $this->integer()->notNull(),
            'type' => $this->string(),
            'start_ts' => $this->dateTime()->notNull(),
            'end_ts' => $this->dateTime()->notNull(),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->createTable('public.lesson', [
            'id' => $this->primaryKey(),
            'teacher_course_id' => $this->integer()->notNull(),
            'teacher_id' => $this->integer(),

//            'language' => $this->string(2), TODO
//            'shift' => $this->smallInteger(), TODO

//            'institution_id' => $this->integer(), // TODO foreign_key
//            'building_id' => $this->integer(), // TODO foreign_key
//            'cabinet_id' => $this->integer(), // TODO foreign_key

            'date_ts' => $this->dateTime()->notNull(),
            'duration' => $this->integer(),

            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->addForeignKey('fk_course_2_discipline', 'public.course', 'discipline_id', 'public.discipline', 'id');

        $this->addForeignKey('fk_teacher_course_2_course', 'public.teacher_course', 'course_id', 'public.course', 'id');
        $this->addForeignKey('fk_teacher_course_2_person', 'public.teacher_course', 'teacher_id', 'person.person', 'id');

        $this->addForeignKey('fk_lesson_2_teacher_course', 'public.lesson', 'teacher_course_id', 'public.course', 'id');
        $this->addForeignKey('fk_lesson_2_person', 'public.lesson', 'teacher_id', 'person.person', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_lesson_2_teacher_course', 'public.lesson');
        $this->dropForeignKey('fk_lesson_2_person', 'public.lesson');
        $this->dropForeignKey('fk_teacher_course_2_person', 'public.teacher_course');
        $this->dropForeignKey('fk_teacher_course_2_course', 'public.teacher_course');
        $this->dropForeignKey('fk_course_2_discipline', 'public.course');

        $this->dropTable('public.lesson');
        $this->dropTable('public.teacher_course');
        $this->dropTable('public.course');
        $this->dropTable('public.discipline');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190206_094835_create_course_related_tables cannot be reverted.\n";

        return false;
    }
    */
}
