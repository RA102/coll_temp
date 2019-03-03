<?php

use yii\db\Migration;

/**
 * Handles the creation of table `person_credentials`.
 */
class m190302_093920_create_person_credential_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('person.person_credential', [
            'id'                   => $this->primaryKey(),
            'person_id'            => $this->integer()->notNull(),
            'indentity'            => $this->string()->notNull()->unique(),
            'password_reset_token' => $this->string(),
            'delete_ts'            => $this->timestamp()->null(),
            'create_ts'            => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts'            => $this->dateTime()->notNull()->defaultValue('now()'),
        ]);

        $this->addForeignKey(
            'fk_person_credential_2_person',
            'person.person_credential',
            'person_id',
            'person.person',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('person.person_credential');
    }
}
