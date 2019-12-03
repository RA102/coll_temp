<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%professional_practice_plan}}`.
 */
class m191009_051628_create_professional_practice_plan_table extends Migration
{
    private $tableName = 'public.professional_practice_plan';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'practice_id' => $this->integer(),
            'group_id' => $this->integer(),
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
