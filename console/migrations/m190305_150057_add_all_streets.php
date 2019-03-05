<?php

use yii\db\Migration;

/**
 * Class m190305_150057_add_all_streets
 */
class m190305_150057_add_all_streets extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->pdo->exec(
            file_get_contents(Yii::getAlias("@console/resources/db_dumps/street_all.sql"))
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
