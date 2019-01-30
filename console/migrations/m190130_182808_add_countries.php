<?php

use yii\db\Migration;

/**
 * Class m190130_182808_add_countries
 */
class m190130_182808_add_countries extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->pdo->exec(
            file_get_contents(Yii::getAlias("@console/resources/db_dumps/country.sql"))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190130_182808_add_countries cannot be reverted.\n";

        return false;
    }
    */
}
