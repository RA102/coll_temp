<?php

use yii\db\Migration;

/**
 * Class m191203_041033_add_advanced_to_institution_table
 */
class m191203_041033_add_advanced_to_institution_table extends Migration
{
    private $tableName = 'organization.institution';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'advanced', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Lesson::tableName(), 'advanced');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191203_041033_add_advanced_to_institution_table cannot be reverted.\n";

        return false;
    }
    */
}
