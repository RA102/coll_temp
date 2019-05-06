<?php

use yii\db\Migration;

/**
 * Class m190506_115244_clear_exam_related_tables
 */
class m190506_115244_clear_exam_related_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete('reception.exam_group_link');
        $this->delete('reception.exam_grade');
        $this->delete('reception.exam');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190506_115244_clear_exam_related_tables cannot be reverted.\n";

        return false;
    }
    */
}
