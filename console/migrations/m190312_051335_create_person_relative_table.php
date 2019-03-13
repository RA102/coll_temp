<?php

use yii\db\Migration;

/**
 * Handles the creation of table `person_relative`.
 */
class m190312_051335_create_person_relative_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('person.person_relative', [
            'id' => $this->primaryKey(),
            'person_id' => $this->integer()->notNull(),
            'firstname' => $this->string(100),
            'lastname' => $this->string(100),
            'middlename' => $this->string(100),
            'birth_date' => $this->date(),
            'residence_city_id' => $this->integer()->null(),
            'residence_address' => $this->string(511),
            'iin' => $this->string(12),
            'relation_type' => $this->smallInteger(),
            'status' => $this->smallInteger(),
            'home_phone' => $this->string(20),
            'mobile_phone' => $this->string(20),
            'email' => $this->string(100),
            'guardian_document_type' => $this->smallInteger(),
            'guardian_document_number' => $this->string(100),
            'guardian_document_issued_date' => $this->date(),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey('fk_person_relative_2_country_unit', 'person.person_relative', 'residence_city_id', 'country_unit', 'id');
        $this->addForeignKey('fk_person_relative_2_person', 'person.person_relative', 'person_id', 'person.person', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_person_relative_2_country_unit', 'person.person_relative');
        $this->dropForeignKey('fk_person_relative_2_person', 'person.person_relative');
        $this->dropTable('person.person_relative');
    }
}
