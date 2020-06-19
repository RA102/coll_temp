<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%institution_department}}`.
 */
class m200619_043233_create_institution_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('organization.institution_department', [
            'id' => $this->primaryKey(),
            'institution_id' => $this->integer()->notNull(),
            'caption' => 'jsonb',
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->createIndex('unique_institution_department', 'organization.institution_department', ['institution_id'], false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('{{%institution_department}}');
    }
}
