<?php

use yii\db\Migration;

/**
 * Class m181212_083810_create_access_tokens
 */
class m181212_083810_create_access_tokens extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('person.access_token', [
            'id' => $this->primaryKey(),
            'person_id' => $this->bigInteger()->notNull(),
            'token' => $this->string()->notNull(),
            'is_temporary' => $this->boolean()->notNull()->defaultValue(true),
            'hash' => $this->string()->null(),
            'create_ts' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'expire_ts' => $this->dateTime()->null(),
            'delete_ts' => $this->dateTime()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('person.access_token');
    }
}
