<?php

use yii\db\Migration;

/**
 * Handles the creation of table `street`.
 */
class m181221_121211_create_street_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('street', [
            'id' => $this->primaryKey(),
            'caption' => $this->string(),
            'city_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'region_city_oid' => $this->bigInteger(),
            'oid' => $this->bigInteger(),
            'server_id' => $this->bigInteger(),
            'kaz_post_id' => $this->string(20),
            'create_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'update_ts' => $this->dateTime()->notNull()->defaultValue('now()'),
            'delete_ts' => $this->dateTime()->null(),
        ]);

        $this->addForeignKey('fk_street_2_country_unit', 'street', 'city_id', 'country_unit', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_street_2_country_unit', 'street');

        $this->dropTable('street');
    }
}
