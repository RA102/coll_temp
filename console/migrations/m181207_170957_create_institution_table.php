<?php

use yii\db\Migration;

/**
 * Handles the creation of table `institution`.
 */
class m181207_170957_create_institution_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE SCHEMA organization;
        ");

        $this->createTable('organization.institution', [
            'id' => $this->primaryKey(),
            'name' => $this->string(511),
            'country_id' => $this->bigInteger()->defaultValue(0),
            'city_id' => $this->bigInteger()->defaultValue(0),
            'parent_id' => $this->bigInteger()->defaultValue(0),
            'type_id' => $this->smallInteger()->defaultValue(0),
            'educational_form_id' => $this->smallInteger()->defaultValue(0),
            'organizational_legal_form_id' => $this->smallInteger()->defaultValue(0),
            'oid' => $this->bigInteger()->defaultValue(0),
            'server_id' => $this->bigInteger(),
            'street_id' => $this->bigInteger(),
            'house_number' => $this->string(255),
            'phone' => $this->string(20),
            'fax' => $this->string(20),
            'email' => $this->string(255),
            'languages_iso' => $this->string(2),
            'description' => $this->text(),
            'bin' => $this->string(50),
            'foundation_year' => $this->smallInteger(),
            'website' => $this->string(50),
            'max_grade' => $this->smallInteger()->defaultValue(0),
            'info' => $this->text(),
            'domain' => $this->string(255),
            'db_name' => $this->string(255),
            'db_user' => $this->string(255),
            'db_password' => $this->string(255),
            'initialization' => $this->boolean()->notNull()->defaultValue(false),
            'status' => $this->smallInteger()->defaultValue(1),
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
        $this->dropTable('organization.institution');

        $this->execute("
            DROP SCHEMA organization;
        ");
    }
}
