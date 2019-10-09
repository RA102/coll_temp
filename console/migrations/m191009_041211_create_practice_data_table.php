<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%practice_data}}`.
 */
class m191009_041211_create_practice_data_table extends Migration
{
    private $tableName = 'public.practice_data';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'practice_id' => $this->integer(),
            'group_id' => $this->integer(),
            'teacher' => 'jsonb',
            'hours' => 'jsonb',
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
