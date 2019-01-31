<?php

use yii\db\Migration;

/**
 * Class m190131_103535_add_default_country_units
 */
class m190131_103535_add_default_country_units extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->pdo->exec(
            file_get_contents(Yii::getAlias("@console/resources/db_dumps/country_unit.sql"))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
