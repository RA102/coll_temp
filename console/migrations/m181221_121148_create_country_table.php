<?php

use yii\db\Migration;

/**
 * Handles the creation of table `country`.
 */
class m181221_121148_create_country_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('country', [
            'id' => $this->primaryKey(),
            'oid' => $this->bigInteger(),
            'name' => $this->string(),
            'caption' => $this->string(),
            'iso' => $this->string(3)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'currency_iso' => $this->string(3),
            'phone_code' => $this->string(10),
            'phone_number_mask' => $this->string(30),
            'catf_mask' => $this->string(30),
            'sort' => $this->integer(),
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
        $this->dropTable('country');
    }
}
