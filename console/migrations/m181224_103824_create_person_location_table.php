<?php

use yii\db\Migration;

/**
 * Handles the creation of table `person_location`.
 */
class m181224_103824_create_person_location_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('person.person_location', [
            'id' => $this->primaryKey(),
            'person_id' => $this->integer()->notNull(),
            'country_id' => $this->integer()->notNull(),
            'country_unit_id' => $this->integer(),
            'street_id' => $this->integer(),
            'status' => $this->smallInteger(),
            'type' => $this->smallInteger(),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->addForeignKey('fk_person_location_2_person', 'person.person_location', 'person_id', 'person.person', 'id');
        $this->addForeignKey('fk_person_location_2_country', 'person.person_location', 'country_id', 'country', 'id');
        $this->addForeignKey('fk_person_location_2_country_unit', 'person.person_location', 'country_unit_id', 'country_unit', 'id');
        $this->addForeignKey('fk_person_location_2_street', 'person.person_location', 'street_id', 'street', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_person_location_2_street', 'person.person_location');
        $this->dropForeignKey('fk_person_location_2_country_unit', 'person.person_location');
        $this->dropForeignKey('fk_person_location_2_country', 'person.person_location');
        $this->dropForeignKey('fk_person_location_2_person', 'person.person_location');

        $this->dropTable('person.person_location');
    }
}
