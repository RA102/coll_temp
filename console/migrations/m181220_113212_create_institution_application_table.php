<?php

use yii\db\Migration;

/**
 * Handles the creation of table `institution_application`.
 */
class m181220_113212_create_institution_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('organization.institution_application', [
            'id' => $this->primaryKey(),
            'iin' => $this->string(50),
            'sex' => $this->smallInteger()->defaultValue(0),
            'email' => $this->string(255),
            'phone' => $this->string(20),
            'name' => $this->string(511),
            'city_id' => $this->bigInteger()->defaultValue(0),
            'type_id' => $this->smallInteger()->defaultValue(0),
            'firstname' => $this->string(100),
            'lastname' => $this->string(100),
            'middlename' => $this->string(100),
            'street' => $this->string(511),
            'birth_date' => $this->date(),
            'house_number' => $this->string(50),
            'educational_form_id' => $this->smallInteger()->defaultValue(0),
            'organizational_legal_form_id' => $this->smallInteger()->defaultValue(0),
            'status' => $this->smallInteger()->defaultValue(0),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('organization.institution_application');
    }
}
