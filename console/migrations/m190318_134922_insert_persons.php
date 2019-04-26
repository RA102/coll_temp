<?php

use yii\db\Migration;

/**
 * Class m190318_134920_insert_persons
 */
class m190318_134922_insert_persons extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->pdo->exec(
            file_get_contents(Yii::getAlias("@console/resources/db_dumps/person_pds.sql"))
        );
        $this->db->pdo->exec(
            file_get_contents(Yii::getAlias("@console/resources/db_dumps/person_credential_pds.sql"))
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
