<?php

use yii\db\Migration;

/**
 * Handles the creation of table `institution_discipline`.
 */
class m190212_115050_create_institution_discipline_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('organization.institution_discipline', [
            'id' => $this->primaryKey(),
            'institution_id' => $this->integer()->notNull(),
            'discipline_id' => $this->integer()->notNull(),
            'types' => 'SMALLINT[]',
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
            'department_id' => $this->integer(),
        ]);

        $this->createIndex('unique_institution_discipline', 'organization.institution_discipline', ['institution_id', 'discipline_id'], true);
        $this->addForeignKey('fk_institution_discipline_2_institution', 'organization.institution_discipline', 'institution_id', 'organization.institution', 'id');
        $this->addForeignKey('fk_institution_discipline_2_discipline', 'organization.institution_discipline', 'discipline_id', 'public.discipline', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_institution_discipline_2_discipline', 'organization.institution_discipline');
        $this->dropForeignKey('fk_institution_discipline_2_institution', 'organization.institution_discipline');
//        $this->dropIndex('unique_institution_discipline', 'organization.institution_discipline');

        $this->dropTable('organization.institution_discipline');
    }
}
