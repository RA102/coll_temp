<?php

use yii\db\Migration;

/**
 * Handles the creation of table `person_contact`.
 */
class m181218_182822_create_person_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('person.person_contact', [
            'id' => $this->primaryKey(),
            'person_id' => $this->integer()->notNull(),
            'name' => $this->string(128)->notNull(),
            'value' => $this->string(255),
            'status' => $this->smallInteger()->defaultValue(1),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
            'UNIQUE (person_id, name)',
        ]);

        $this->addForeignKey('fk_person_contact_2_person', 'person.person_contact', 'person_id', 'person.person', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_person_contact_2_person', 'person.person_contact');

        $this->dropTable('person.person_contact');
    }
}
