<?php

use yii\db\Migration;

/**
 * Handles the creation of table `teacher_course_group_link`.
 */
class m190222_110655_create_teacher_course_group_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('link.teacher_course_group_link', [
            'id' => $this->primaryKey(),
            'teacher_course_id' => $this->integer()->notNull(),
            'group_id' => $this->integer()->notNull(),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->addForeignKey(
            'fk_teacher_course_group_link_2_teacher_course',
            'link.teacher_course_group_link', 
            'teacher_course_id',
            'public.teacher_course',
            'id'
        );
        $this->addForeignKey(
            'fk_teacher_course_group_link_2_group_id',
            'link.teacher_course_group_link',
            'group_id',
            'organization.group',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_teacher_course_group_link_2_group_id',
            'link.teacher_course_group_link'
        );
        $this->dropForeignKey(
            'fk_teacher_course_group_link_2_teacher_course',
            'link.teacher_course_group_link'
        );

        $this->dropTable('link.teacher_course_group_link');
    }
}
