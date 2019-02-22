<?php

use yii\db\Migration;

/**
 * Class m190222_112947_fix_foreign_key_lesson
 */
class m190222_112947_fix_foreign_key_lesson extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete('public.lesson');
        $this->dropForeignKey('fk_lesson_2_teacher_course', 'public.lesson');
        $this->addForeignKey('fk_lesson_2_teacher_course', 'public.lesson', 'teacher_course_id', 'public.teacher_course', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('public.lesson');
        $this->dropForeignKey('fk_lesson_2_teacher_course', 'public.lesson');
        $this->addForeignKey('fk_lesson_2_teacher_course', 'public.lesson', 'teacher_course_id', 'public.course', 'id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190222_112947_fix_foreign_key_lesson cannot be reverted.\n";

        return false;
    }
    */
}
