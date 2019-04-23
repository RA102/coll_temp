<?php

use yii\db\Migration;

/**
 * Handles the creation of table `reception_group`.
 */
class m190423_160508_create_reception_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('reception.group', [
            'id' => $this->primaryKey(),
            'caption' => 'jsonb',
            'language' => $this->string(2),
            'speciality_id' => $this->integer(),
            'education_form' => $this->integer(),
            'institution_id' => $this->integer(),
            'budget_places' => $this->integer(),
            'commercial_places' => $this->integer(),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->timestamp(),
            'delete_ts' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey(
            'fk_reception_group_2_speciality',
            'reception.group',
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
        $this->dropForeignKey('fk_reception_group_2_speciality', 'reception.group');
        $this->dropTable('reception.group');
    }
}
