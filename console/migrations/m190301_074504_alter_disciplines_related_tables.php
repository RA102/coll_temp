<?php

use yii\db\Migration;

/**
 * Class m190301_074504_alter_disciplines_related_tables
 */
class m190301_074504_alter_disciplines_related_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organization.institution_discipline', 'caption', 'jsonb');
        $this->addColumn('organization.institution_discipline', 'slug', $this->string());
        $this->addColumn('organization.institution_discipline', 'status', $this->smallInteger());
        $this->alterColumn('organization.institution_discipline', 'discipline_id', 'DROP NOT NULL');
        $this->alterColumn('organization.institution_discipline', 'discipline_id', 'SET DEFAULT NULL');

        $this->dropIndex('organization.unique_institution_discipline', 'institution_discipline');

        // Remove old relational data
        $this->delete('link.teacher_course_group_link');
        $this->delete('public.lesson');
        $this->delete('public.teacher_course');
        $this->delete('public.course');

        $this->dropForeignKey('fk_course_2_discipline', 'public.course');
        $this->dropForeignKey('fk_course_2_institution', 'public.course');
        $this->dropColumn('public.course', 'discipline_id');
        $this->dropColumn('public.course', 'institution_id');
        $this->addColumn('public.course', 'institution_discipline_id', $this->integer()->notNull());
        $this->addForeignKey('fk_course_2_institution_discipline', 'public.course', 'institution_discipline_id', 'organization.institution_discipline', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_course_2_institution_discipline', 'public.course');
        $this->dropColumn('public.course', 'institution_discipline_id');
        $this->addColumn('public.course', 'institution_id', $this->integer()->notNull());
        $this->addColumn('public.course', 'discipline_id', $this->integer()->notNull());
        $this->addForeignKey('fk_course_2_institution', 'public.course', 'institution_id', 'organization.institution', 'id');
        $this->addForeignKey('fk_course_2_discipline', 'public.course', 'discipline_id', 'public.discipline', 'id');


        $this->createIndex('unique_institution_discipline', 'organization.institution_discipline', ['institution_id', 'discipline_id'], true);

        $this->alterColumn('organization.institution_discipline', 'discipline_id', 'SET NOT NULL');
        $this->dropColumn('organization.institution_discipline', 'status');
        $this->dropColumn('organization.institution_discipline', 'slug');
        $this->dropColumn('organization.institution_discipline', 'caption');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190301_074504_alter_disciplines_related_tables cannot be reverted.\n";

        return false;
    }
    */
}
