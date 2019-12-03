<?php

use yii\db\Migration;

/**
 * Class m191008_113258_add_columns_to_optional_disciplines_table
 */
class m191008_113258_add_columns_to_optional_disciplines_table extends Migration
{
    private $tableName = 'public.optional_disciplines';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'teacher_course_id', $this->integer());
        $this->addColumn($this->tableName, 'ktp', 'jsonb');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'teacher_course_id');
        $this->dropColumn($this->tableName, 'ktp');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_113258_add_columns_to_optional_disciplines_table cannot be reverted.\n";

        return false;
    }
    */
}
