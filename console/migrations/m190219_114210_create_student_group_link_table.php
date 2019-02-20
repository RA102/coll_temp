<?php

use yii\db\Migration;

/**
 * Handles the creation of table `student_group_link`.
 */
class m190219_114210_create_student_group_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('link.student_group_link', [
            'id' => $this->primaryKey(),
            'student_id' => $this->bigInteger()->notNull(),
            'group_id' => $this->bigInteger()->notNull(),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->addForeignKey(
            'fk_student_group_link_2_speciality',
            'link.student_group_link',
            'student_id',
            'person.person',
            'id'
        );

        $this->addForeignKey(
            'fk_student_group_link_2_group',
            'link.student_group_link',
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
        $this->dropForeignKey('fk_student_group_link_2_group', 'link.student_group_link');
        $this->dropForeignKey('fk_student_group_link_2_speciality', 'link.student_group_link');

        $this->dropTable('link.student_group_link');
    }
}
