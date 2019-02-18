<?php

use yii\db\Migration;

/**
 * Class m190218_103454_alter_courses_table
 */
class m190218_103454_alter_courses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('public.course', 'grades');
        $this->addColumn('public.course', 'classes', 'SMALLINT[]');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('public.course', 'classes');
        $this->addColumn('public.course', 'grades', $this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190218_103454_alter_courses_table cannot be reverted.\n";

        return false;
    }
    */
}
