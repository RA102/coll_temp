<?php

use yii\db\Migration;

/**
 * Class m191028_002952_change_person_table
 */
class m191028_002952_change_person_table extends Migration
{
    private $tableName = 'person.person';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'lang', 'jsonb');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'lang');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191028_002952_change_person_table cannot be reverted.\n";

        return false;
    }
    */
}
