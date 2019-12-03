<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%professional_practice}}`.
 */
class m191009_015933_create_professional_practice_table extends Migration
{
    private $tableName = 'public.professional_practice';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer(),
            'type' => $this->integer(),
            'weeks' => 'jsonb',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
