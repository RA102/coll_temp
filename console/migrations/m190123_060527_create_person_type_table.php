<?php

use yii\db\Migration;

/**
 * Handles the creation of table `person_type`.
 */
class m190123_060527_create_person_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('person.person_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'parent_id' => $this->bigInteger()->defaultValue(0),
            'home_page' => $this->string(),
            'group' => $this->smallInteger()->notNull(),
            'oid' => $this->bigInteger(),
            'is_deleted' => $this->boolean()->defaultValue(false),
            'create_ts' => $this->timestamp()->defaultExpression('now()'),
            'priority' => $this->integer(),
        ]);

        $this->execute('ALTER TABLE person.person_type ADD COLUMN action integer[], ADD COLUMN caption jsonb;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('person.person_type');
    }
}
