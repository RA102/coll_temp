<?php

use yii\db\Migration;

/**
 * Handles the creation of table `group`.
 */
class m190210_164928_create_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('organization.group', [
            'id' => $this->primaryKey(),
            'caption' => 'jsonb',
            'language' => $this->string(2),
            'speciality_id' => $this->integer(),
            'max_class' => $this->tinyInteger(),
            'class' => $this->tinyInteger(),
            'education_form' => $this->integer(),
            'education_pay_form' => $this->integer(),
            'institution_id' => $this->integer(),
            'parent_id' => $this->integer(),
            'type' => $this->integer(),
            'rating_system_id' => $this->integer(),
            'based_classes' => $this->integer() . '[]',
            'class_change_history' => 'jsonb',
            'properties' => 'jsonb',
            'is_deleted' => $this->boolean()->defaultValue(false),
            'start_ts' => $this->timestamp(),
            'create_ts' => $this->timestamp(),
            'update_ts' => $this->timestamp(),
            'delete_ts' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey(
            'fk_group_2_group',
            'organization.group',
            'parent_id',
            'organization.group',
            'id'
        );

        $this->addForeignKey(
            'fk_group_2_institution',
            'organization.group',
            'institution_id',
            'organization.institution',
            'id'
        );

        $this->addForeignKey(
            'fk_group_2_speciality',
            'organization.group',
            'speciality_id',
            'handbook.speciality',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_group_2_speciality', 'organization.group');
        $this->dropForeignKey('fk_group_2_institution', 'organization.group');
        $this->dropForeignKey('fk_group_2_group', 'organization.group');
        $this->dropTable('organization.division');
    }
}
