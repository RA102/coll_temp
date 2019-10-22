<?php

use yii\db\Migration;

/**
 * Class m191021_221908_add_director_to_institution_table
 */
class m191021_221908_add_director_to_institution_table extends Migration
{
    private $tableName = 'organization.institution';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'director', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Lesson::tableName(), 'director');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191021_221908_add_director_to_institution_table cannot be reverted.\n";

        return false;
    }
    */
}
