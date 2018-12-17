<?php

use yii\db\Migration;

/**
 * Handles the creation of table `person_info`.
 */
class m181217_072456_create_person_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('person.person_info', [
            'person_id' => $this->integer()->notNull(),
            'name' => $this->string(128)->notNull(),
            'value' => $this->string(255),
            'status' => $this->smallInteger()->defaultValue(1),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
            'PRIMARY KEY (person_id, name)',
        ]);

        $this->addForeignKey('fk_person_info_2_person', 'person.person_info', 'person_id', 'person.person', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_person_info_2_person', 'person.person_info');

        $this->dropTable('person.person_info');
    }
}
