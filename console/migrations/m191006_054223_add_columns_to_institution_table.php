<?php

use yii\db\Migration;

/**
 * Class m191006_054223_add_columns_to_institution_table
 */
class m191006_054223_add_columns_to_institution_table extends Migration
{
    private $tableName = 'organization.institution';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'semester_date', 'jsonb');
        $this->addColumn($this->tableName, 'shift_time', 'jsonb');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Lesson::tableName(), 'semester_date');
        $this->dropColumn(Lesson::tableName(), 'shift_time');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191006_054223_add_columns_to_institution_table cannot be reverted.\n";

        return false;
    }
    */
}
