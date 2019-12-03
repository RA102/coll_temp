<?php

use yii\db\Migration;

/**
 * Class m191010_041150_add_type_column_to_schedule_lesson
 */
class m191010_041150_add_type_column_to_schedule_lesson extends Migration
{
    private $tableName = 'public.schedule';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'type', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191010_041150_add_type_column_to_schedule_lesson cannot be reverted.\n";

        return false;
    }
    */
}
