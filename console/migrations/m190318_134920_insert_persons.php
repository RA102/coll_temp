<?php

use yii\db\Migration;

/**
 * Class m190318_134920_insert_persons
 */
class m190318_134920_insert_persons extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* Fix migration for running in empty databases */
//        $this->db->pdo->exec(
//            file_get_contents(Yii::getAlias("@console/resources/db_dumps/person_pds.sql"))
//        );
//        $this->db->pdo->exec(
//            file_get_contents(Yii::getAlias("@console/resources/db_dumps/person_credential_pds.sql"))
//        );
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
        echo "m190318_134920_insert_persons cannot be reverted.\n";

        return false;
    }
    */
}
