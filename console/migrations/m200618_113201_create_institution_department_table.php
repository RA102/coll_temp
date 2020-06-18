<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%institution_department}}`.
 */
class m200618_113201_create_institution_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('organization.institution_discipline', [
            'id' => $this->primaryKey(),
            'institution_id' => $this->integer()->notNull(),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->createIndex('unique_institution_discipline', 'organization.institution_discipline', ['institution_id'], true);
        $this->addForeignKey('fk_institution_discipline_2_institution', 'organization.institution_discipline', 'institution_id', 'organization.institution', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_institution_discipline_2_institution', 'organization.institution_discipline');

        $this->dropTable('{{%institution_department}}');
    }
}
