<?php

use yii\db\Migration;

/**
 * Handles the creation of table `country_unit`.
 */
class m181221_121159_create_country_unit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('country_unit', [
            'id' => $this->primaryKey(),
            'oid' => $this->bigInteger(),
            'name' => $this->string(),
            'phone_code' => $this->string(40),
            'country_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer(),
            'unit_type' => $this->smallInteger(),
            'caption' => $this->string(),
            'status' => $this->smallInteger(),
            'catf_code' => $this->bigInteger(),
            'kaz_post_id' => $this->string(20),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->addForeignKey('fk_country_unit_2_country', 'country_unit', 'country_id', 'country', 'id');
        $this->addForeignKey('fk_country_unit_2_country_unit', 'country_unit', 'parent_id', 'country_unit', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_country_unit_2_country_unit', 'country_unit');
        $this->dropForeignKey('fk_country_unit_2_country', 'country_unit');

        $this->dropTable('country_unit');
    }
}
