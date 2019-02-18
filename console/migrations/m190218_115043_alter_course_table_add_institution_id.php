<?php

use yii\db\Migration;

/**
 * Class m190218_115043_alter_course_table_add_institution_id
 */
class m190218_115043_alter_course_table_add_institution_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete('public.course');
        $this->addColumn('public.course', 'institution_id', $this->integer()->notNull());
        $this->addForeignKey('fk_course_2_institution', 'public.course', 'institution_id', 'organization.institution', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_course_2_institution', 'public.course');
        $this->dropColumn('public.course', 'institution_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190218_115043_alter_course_table_add_institution_id cannot be reverted.\n";

        return false;
    }
    */
}
