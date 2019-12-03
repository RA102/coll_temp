<?php

use yii\db\Migration;

/**
 * Class m191009_015902_add_caption_to_practice_table
 */
class m191009_015902_add_caption_to_practice_table extends Migration
{
    private $tableName = 'public.practice';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'caption', 'jsonb');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'caption');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191009_015902_add_caption_to_practice_table cannot be reverted.\n";

        return false;
    }
    */
}
