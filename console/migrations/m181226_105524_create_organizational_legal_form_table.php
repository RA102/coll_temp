<?php

use yii\db\Migration;

/**
 * Handles the creation of table `organizational_legal_form`.
 */
class m181226_105524_create_organizational_legal_form_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('organization.organizational_legal_form', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'caption' => 'jsonb',
            'status' => $this->smallInteger()->defaultValue(1),
            'is_deleted' => $this->boolean(),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'oid' => $this->bigInteger(),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->db->pdo->exec(
            file_get_contents(Yii::getAlias("@console/resources/db_dumps/organizational_legal_form.sql"))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('organization.organizational_legal_form');
    }
}
