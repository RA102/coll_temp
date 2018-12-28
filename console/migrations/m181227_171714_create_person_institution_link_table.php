<?php

use yii\db\Migration;

/**
 * Handles the creation of table `person_institution_link`.
 */
class m181227_171714_create_person_institution_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE SCHEMA link;
        ");

        $this->createTable('link.person_institution_link', [
            'id' => $this->primaryKey(),
            'person_id' => $this->bigInteger()->notNull(),
            'institution_id' => $this->bigInteger()->notNull(),
            'from_ts' => $this->dateTime()->null(),
            'to_ts' => $this->dateTime()->null(),
            'status' => $this->smallInteger()->defaultValue(1),
            'person_type' => $this->string(100),
            'index' => $this->bigInteger(),
            'is_deleted' => $this->boolean()->defaultValue(false),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'position' => $this->string(100),
            'document_submission_date' => $this->date(),
            'comment' => $this->string(255),
            'condition' => $this->smallInteger(),
            'unfasten_reason_id' => $this->smallInteger(),
            'is_pluralist' => $this->boolean(),
            'import_ts' => $this->dateTime(),
            'document_number' => $this->bigInteger()
        ]);

        $this->addForeignKey(
            'fk_person_institution_link_2_person',
            'link.person_institution_link',
            'person_id',
            'person.person',
            'id'
        );
        $this->addForeignKey(
            'fk_person_institution_link_2_institution',
            'link.person_institution_link',
            'institution_id',
            'organization.institution',
            'id'
        );

        $this->createIndex(
            'unique_person_institution',
            'link.person_institution_link',
            ['person_id', 'institution_id', 'is_deleted'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_person_institution_link_2_institution', 'link.person_institution_link');
        $this->dropForeignKey('fk_person_institution_link_2_person', 'link.person_institution_link');
        $this->dropTable('link.person_institution_link');

        $this->execute("
            DROP SCHEMA link;
        ");
    }
}
