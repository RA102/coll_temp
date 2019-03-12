<?php

use yii\db\Migration;

/**
 * Class m190305_110729_add_all_country_units
 */
class m190305_110729_add_all_country_units extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk_country_unit_2_country_unit', 'country_unit');

        $this->db->pdo->exec(
            file_get_contents(Yii::getAlias("@console/resources/db_dumps/country_unit_all.sql"))
        );

        $this->addForeignKey('fk_country_unit_2_country_unit', 'country_unit', 'parent_id', 'country_unit', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
