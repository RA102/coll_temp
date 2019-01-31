<?php

use yii\db\Migration;

/**
 * Class m190131_104311_add_default_streets
 */
class m190131_104311_add_default_streets extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->pdo->exec(
            file_get_contents(Yii::getAlias("@console/resources/db_dumps/street.sql"))
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
