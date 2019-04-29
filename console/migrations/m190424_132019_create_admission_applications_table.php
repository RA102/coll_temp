<?php

use yii\db\Migration;

/**
 * Handles the creation of table `applications`.
 */
class m190424_132019_create_admission_applications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('CREATE SCHEMA educational_process');

        // TODO: add foreign key constraints
        $this->createTable('educational_process.application', [
            'id'             => $this->primaryKey(),
            'status'         => $this->smallInteger()->notNull(),
            'institution_id' => $this->integer()->notNull(),
            'person_id'      => $this->integer(),
            'properties'     => 'jsonb',
            'type'           => $this->smallInteger()->notNull(),
            'is_deleted'     => $this->boolean()->defaultValue(false)->notNull(),
            'delete_ts'      => $this->timestamp(),
            'create_ts'      => $this->timestamp()->defaultExpression('now()'),
            'update_ts'      => $this->timestamp()->defaultExpression('now()')
        ]);
        $this->addForeignKey('fk_educational_process_application_institution_id',
            'educational_process.application',
            'institution_id',
            'organization.institution',
            'id'
        );
        $this->addForeignKey('fk_educational_process_application_person_id',
            'educational_process.application',
            'person_id',
            'person.person',
            'id'
        );

        $this->insert('person.person_type', [
            'name'  => 'entrant',
            'group' => 2 // clarify to which group entrant belongs to
        ]);

        $this->createTable('handbook.person_social_status', [
            'id'         => $this->primaryKey(),
            'caption'    => 'jsonb',
            'name'       => $this->char(200)->notNull(),
            'type'       => 'integer[] not null',
            'grouping'   => 'smallint[]',
            'create_ts'  => $this->timestamp()->defaultExpression('now()'),
            'is_deleted' => $this->boolean()->defaultValue(false),
            'oid'        => $this->bigInteger(),
            'server_id'  => $this->bigInteger()
        ]);

        $this->createTable('link.person_social_status_link', [
            'person_id'        => $this->bigInteger()->notNull(),
            'social_status_id' => $this->bigInteger()->notNull(),
            'create_ts'        => $this->timestamp()->defaultExpression('now()'),
            'is_deleted'       => $this->boolean()->defaultValue(false),
            'delete_ts'        => $this->timestamp(),
            'index'            => 'bigserial not null',
            'document_number'  => $this->char(255),
            'comment'          => $this->char(1024)
        ]);
        $this->addForeignKey('fk_link_person_social_status_link_social_status_id',
            'link.person_social_status_link',
            'social_status_id',
            'handbook.person_social_status',
            'id'
        );
        $this->addForeignKey('fk_link_person_social_status_link_person_id',
            'link.person_social_status_link',
            'person_id',
            'person.person',
            'id'
        );

        $this->addPrimaryKey(
            'person_social_status_link_pkey',
            'link.person_social_status_link',
            [
                'person_id',
                'social_status_id',
//                'index'
            ]
        );

        $this->db->pdo->exec(
            file_get_contents(Yii::getAlias("@console/resources/db_dumps/person_social_status.sql"))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('link.person_social_status_link');
        $this->dropTable('handbook.person_social_status');

        $this->delete('person.person_type', ['name' => 'entrant']);
        $this->dropTable('educational_process.application');
        $this->execute('DROP SCHEMA educational_process');
    }
}
