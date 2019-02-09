<?php

use yii\db\Migration;

/**
 * Handles the creation of table `institution_speciality_link`.
 */
class m190208_175058_create_institution_speciality_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('organization.institution_speciality_info', [
            'id' => $this->primaryKey(),
            'speciality_id' => $this->bigInteger()->notNull(),
            'institution_id' => $this->bigInteger()->notNull(),
            'caption' => 'jsonb',
            'status' => $this->smallInteger(),
            'create_ts' => $this->timestamp(),
            'is_deleted' => $this->boolean(),
            'default_grade' => $this->smallInteger(),
            'parent_id' => $this->bigInteger(),
            'academic_year_id' => $this->smallInteger(),
            'oid' => $this->bigInteger(),
            'server_id' => $this->bigInteger(),
        ]);

        $this->addForeignKey(
            'fk_institution_speciality_info_2_speciality',
            'organization.institution_speciality_info',
            'speciality_id',
            'handbook.speciality',
            'id'
        );

        $this->addForeignKey(
            'fk_institution_speciality_info_2_institution',
            'organization.institution_speciality_info',
            'institution_id',
            'organization.institution',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_institution_speciality_info_2_institution', 'organization.institution_speciality_info');
        $this->dropForeignKey('fk_institution_speciality_info_2_speciality', 'organization.institution_speciality_info');
        $this->dropTable('organization.institution_speciality_info');
    }
}
